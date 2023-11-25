<?php

namespace App\Http\Controllers;

use App\Models\ReportedQuestion;
use App\Models\ReportedReply;
use App\Models\ReportedUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{
    // Return template register (GET method)
    public function register() {
        return view('user.register');
    }

    // Store registered user (POST method)
    public function registerPost(Request $request) {
        $validated = $request->validate(
            [
                'name' => 'required|ascii',
                'email' => 'required|email',
                'password' => 'required|confirmed|min:8',
            ],

            [
                'name.required' => 'Harap isikan nama lengkap Anda',
                'name.ascii' => 'Nama lengkap Anda hanya boleh menggunakan karakter ASCII',

                'email.required' => 'Harap isikan email Anda',
                'email.email' => 'Harap isikan email Anda dengan format yang benar',

                'password.required' => 'Harap isikan password untuk akun Anda',
                'password.confirmed' => 'Harap konfirmasikan password Anda dengan benar',
                'password.min' => 'Password Anda harus memiliki minimal 8 karakter',
            ]
        );

        // Check if user already exists
        if (User::where('email', $request->email)->first() != null) {
            return back()->withErrors('Email is already in use!');
        }

        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = 'user';

        $user->save();

        Session::flash('message-success', 'Registrasi berhasil');
        return redirect('/register');
    }

    // Return template login (GET method)
    public function login() {
        return view('user.login');
    }

    // Login user (POST method)
    public function loginPost(Request $request) {
        $validated = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required'
            ],

            [
                'email.required' => 'Harap isikan email Anda',
                'email.email' => 'Harap isikan email Anda dengan format yang benar',
                'password.required' => 'Harap isikan password Anda'
            ]
        );

        // Jika authentication berhasil
        if (Auth::attempt($validated)) {
            $request->session()->regenerate();

            return redirect()->intended('/user/dashboard');
        }

        // Jika authentication tidak berhasil
        return back()->withErrors('Email tidak ditemukan atau password salah')->onlyInput('email');
    }

    // Logout
    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // View user profile
    public function profile(int $id) {
        $user = User::findOrFail($id);

        // if ($user == null) {
        //     return redirect('/user/dashboard')->withErrors('User not found!');
        // }

        return view('user.profile', ['user' => $user]);
    }

    // Return dashboard view
    public function dashboard() {
        // If the user is an admin, show reports
        $reportedQuestions = null;
        $reportedReplies = null;

        if (Auth::user()->role == 'admin') {
            $reportedQuestions = ReportedQuestion::select('id', 'user_id', 'reported_id', 'reason')
            ->get()
            ->groupBy('reported_id')
            ->take(10);

            $reportedReplies = ReportedReply::select('id', 'user_id', 'reported_id', 'reason')
            ->get()
            ->groupBy('reported_id')
            ->take(10);

            $reportedUsers = ReportedUser::select('id', 'user_id', 'reported_id', 'reason')
            ->get()
            ->groupBy('reported_id')
            ->take(10);
        }

        return view(
            'user.dashboard',
            [
                'user' => Auth::user(),
                'reportedQuestions' => $reportedQuestions,
                'reportedReplies' => $reportedReplies,
                'reportedUsers' => $reportedUsers,
            ]
        );
    }

    // Edit account
    public function edit(Request $request) {
        $validated = $request->validate(
            [
                'name' => 'required|ascii',
                'about' => 'ascii',
                'image' => 'image|max:2048',
            ],

            [
                'name.required' => 'Harap isikan nama lengkap Anda',
                'name.ascii' => 'Nama lengkap Anda hanya boleh menggunakan karakter ASCII',

                'about.ascii' => 'About hanya boleh menggunakan karakter ASCII',

                'image.image' => 'Format file yang diizinkan hanya jpg, jpeg, png, bmp, gif, svg, dan webp',
                'image.max' => 'Ukuran file maksimum adalah 2MB'
            ]
        );

        // Update user
        $user = $request->user();

        $user->name = $request->name;
        $user->about = $request->about;

        // Upload gambar jika ada
        if (!empty($request->image)) {
            $filename = time() . '.' . $request->image->extension();
            $request->image->move(public_path('storage/uploads'), $filename);

            // Jika user sudah punya profile image, hapus profile image lama
            if (!empty($user->image_url) && $user->image_url !== '') {
                unlink(public_path('storage/uploads/' . $user->image_url));
            }

            // Update image url user
            $user->image_url = $filename;
        }

        $user->save();

        return redirect('/user/dashboard');
    }

    // Change password
    public function changePassword(Request $request) {
        $validated = $request->validate(
            [
                'password' => 'required|current_password',
                'new_password' => 'required|confirmed',
            ],

            [
                'password.required' => 'Harap isikan password lama Anda',
                'password.current_password' => 'Password yang Anda isikan salah',

                'new_password.required' => 'Harap isikan password baru Anda',
                'new_password.confirmed' => 'Harap konfirmasikan password baru Anda dengan benar',
            ]
        );

        // Update user
        $user = $request->user();
        $user->password = bcrypt($request->new_password);
        $user->save();

        Session::flash('message-success', 'Password berhasil diubah!');
        return redirect('/user/dashboard');
    }

    // Delete account
    public function delete(Request $request) {
        $validated = $request->validate(
            [
                'password' => 'required|current_password',
            ],

            [
                'password.required' => 'Harap isikan password Anda',
                'password.current_password' => 'Password yang Anda isikan salah',
            ]
        );

        $user = $request->user();

        // Logout user
        Auth::logout();

        $user->delete();

        Session::flash('message-success', 'Akun berhasil dihapus');
        return redirect('/logout');
    }

    // Delete profile image
    public function deleteImage(Request $request) {
        $user = $request->user();

        // Jika user sudah punya profile image, hapus profile image lama
        if (!empty($user->image_url) && $user->image_url !== '') {
            unlink(public_path('storage/uploads/' . $user->image_url));
        }

        // Update image url user
        $user->image_url = '';
        $user->save();

        Session::flash('message-success', 'Gambar profile berhasil dihapus!');
        return redirect('/user/dashboard');
    }

    // Function to report a user
    public function report(int $id) {
        $user = User::findOrFail($id);

        return view('report.user', ['user' => $user]);
    }

    // Report user post
    public function reportPost(Request $request, int $id) {
        $user = User::findOrFail($id);

        $validated = $request->validate(
            ['reason' => 'required'],
            ['reason.required' => 'Reporting reason is required']
        );

        // Check if the user has already reported this user
        $report = $user->userReport();

        if ($report != null) {
            return back()->withErrors('You have already reported this user!');
        }

        // Create the report
        $report = new ReportedUser;

        $report->user_id = Auth::id();
        $report->reported_id = $user->id;
        $report->reason = $request->reason;

        $report->save();

        Session::flash('message-success', 'User reported successfully!');
        return back();
    }

    // Function to remove a report
    public function removeReport(int $id) {
        $user = User::findOrFail($id);

        $report = $user->userReport();

        if ($report == null) {
            return back()->withErrors('You have not reported this user!');
        }

        $report->delete();

        Session::flash('message-success', 'Removed report successfully!');
        return back();
    }

    // Function to show all reported users
    public function reportedList(Request $request) {
        $page = max(0, $request->page - 1);

        $reported = ReportedUser::offset($page * 20)
        ->limit(20)
        ->get()
        ->groupBy('reported_id')
        ->sortDesc();

        return view('user.reportedList', ['reported' => $reported]);
    }

    // Function to show all the reports for a reported user
    public function reportedListView(Request $request, int $id) {
        $page = max(0, $request->page - 1);

        $user = User::findOrFail($id);
        $reports = ReportedUser::where('reported_id', $id)
        ->offset($page * 20)
        ->limit(20)
        ->get();

        return view('user.reportedListView', ['user' => $user, 'reports' => $reports]);
    }
}

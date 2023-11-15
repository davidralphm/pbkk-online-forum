<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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

        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

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

            return redirect()->intended('/dashboard');
        }

        // Jika authentication tidak berhasil
        return back()->withErrors(
            [
                'email' => 'Email tidak ditemukan'
            ]
        )->onlyInput('email');
    }

    // Logout
    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // Return dashboard view
    public function dashboard() {
        return view('user.dashboard', ['user' => Auth::user()]);
    }
}

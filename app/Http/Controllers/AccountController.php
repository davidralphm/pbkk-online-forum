<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only([
            'dashboard',
            'edit',
            'editPost',
            'delete',
            'deletePost',
        ]);
    }

    public function index() {
        return Redirect::route('account.login');
    }

    public function login() {
        return view('account.login');
    }

    public function loginPost(Request $request) {
        $validated = $request->validate(
            [
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'username.required' => 'Please enter your username',
                'password.required' => 'Please enter your password',
            ]
        );

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();

            Session::flash('message-success', 'Logged in successfully');
            return Redirect::intended(route('account.dashboard'));
        }

        return Redirect::back()->withErrors(
            [
                'username,password' => 'Invalid username or password',
            ]
        )->onlyInput('username');
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerate();

        return Redirect::route('account.login');
    }

    public function register() {
        return view('account.register');
    }

    public function registerPost(Request $request) {
        // Perform validation
        $validated = $request->validate(
            [
                'username' => 'required|alpha_num|unique:App\Models\User,username',
                'first_name' => 'required|ascii',
                'last_name' => 'required|ascii',
                'email' => 'required|email|unique:App\Models\User,email',
                'password' => 'required|confirmed',
            ],
            [
                'username.required' => 'Please enter your username',
                'username.alpha_num' => 'Username can only contain alpha numeric characters',
                'username.unique' => 'Username is already taken',

                'first_name.required' => 'Please enter your first name',
                'first_name.ascii' => 'Your first name can only contain alphabet characters',

                'last_name.required' => 'Please enter your first name',
                'last_name.ascii' => 'Your first name can only contain alphabet characters',

                'email.required' => 'Please enter your e-mail address',
                'email.email' => 'Please enter a valid e-mail address',
                'email.unique' => 'E-mail address is already registered',

                'password.required' => 'Please enter your password',
                'password.confirmed' => 'Please confirm your password',
            ]
        );

        // Create the user
        $user = new User($validated);
        $user->save();

        Session::flash('message-success', 'Account registration successful');
        return Redirect::route('account.login');
    }

    public function dashboard() {
        return view('account.dashboard');
    }

    public function edit() {
        return view('account.edit', [ 'user' => Auth::user() ]);
    }

    public function editPost(Request $request) {
        $validated = $request->validate(
            [
                'first_name' => 'required|ascii',
                'last_name' => 'required|ascii',
                'email' => 'required|email',
                'signature' => 'nullable',
                'image' => 'nullable', // Don't forget to check MIME types, and limit file size
            ],

            [
                'first_name.required' => 'Please enter your first name',
                'first_name.ascii' => 'Your first name can only contain alphabet characters',

                'last_name.required' => 'Please enter your first name',
                'last_name.ascii' => 'Your first name can only contain alphabet characters',

                'email.required' => 'Please enter your e-mail address',
                'email.email' => 'Please enter a valid e-mail address',
                'email.unique' => 'E-mail address is already registered',

                // 'signature.text' => 'Please enter a valid signature',
            ]
        );

        $user = User::find(Auth::user()->id);

        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->email = $validated['email'];
        $user->signature = $validated['signature'];

        $user->save();

        Session::flash('message-success', 'Account updated successfully');
        return Redirect::route('account.dashboard');
    }

    public function delete() {
        return view('account.delete');
    }

    public function deletePost(Request $request) {
        return view('account.delete');
    }
}

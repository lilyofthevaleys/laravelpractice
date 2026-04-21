<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        $intended = session('url.intended', '');
        $fromCheckout = str_ends_with($intended, '/checkout');

        return view('auth.login', compact('fromCheckout'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors(['email' => 'Those credentials don\'t match any trainer in our records.']);
        }

        $request->session()->regenerate();

        $landing = Auth::user()->isAdmin() ? route('admin.dashboard') : route('shop');

        return redirect()->intended($landing)->with('success', 'Welcome back, ' . Auth::user()->name . '!');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'email.unique' => 'A trainer is already registered with that email.',
        ]);

        $user = User::create($data);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', "Welcome to Pokémart, Trainer {$user->name}!");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You\'ve logged out. See you next adventure!');
    }
}

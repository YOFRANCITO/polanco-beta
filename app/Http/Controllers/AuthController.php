<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show login form.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard-analytics');
        }

        return view('content.authentications.auth-login-basic');
    }

    /**
     * Handle login submission.
     */
    public function login(Request $request)
    {
        $input = trim($request->input('email', ''));
        if (strtolower($input) === 'admin') {
            $request->merge(['email' => 'admin@clubpolanco.com']);
        } elseif (strtolower($input) === 'operador') {
            $request->merge(['email' => 'operador@clubpolanco.com']);
        }

        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'El usuario o correo electrónico es requerido.',
            'password.required' => 'La contraseña es requerida.',
        ]);

        $remember = $request->has('remember');

        // Buscar por correo o nombre de usuario
        $user = \App\Models\User::where('email', $credentials['email'])
            ->orWhere('name', $credentials['email'])
            ->first();

        if ($user && \Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password)) {
            if ($user->estado !== 'activo') {
                return back()->withErrors(['email' => 'Su cuenta se encuentra inactiva. Contacte al administrador.'])->withInput();
            }
            Auth::login($user, $remember);
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard-analytics'))->with('success', '¡Bienvenido(a) a Club Polanco!');
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->withInput();
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
    }
}

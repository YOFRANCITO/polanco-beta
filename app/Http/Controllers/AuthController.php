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
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'El correo electrónico es requerido.',
            'email.email' => 'Ingrese un correo electrónico válido.',
            'password.required' => 'La contraseña es requerida.',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password'], 'estado' => 'activo'], $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard-analytics'))->with('success', '¡Bienvenido(a) a Club Polanco!');
        }

        // Check if user exists but is inactive
        $inactive = \App\Models\User::where('email', $credentials['email'])->where('estado', 'inactivo')->first();
        if ($inactive) {
            return back()->withErrors(['email' => 'Su cuenta se encuentra inactiva. Contacte al administrador.'])->withInput();
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

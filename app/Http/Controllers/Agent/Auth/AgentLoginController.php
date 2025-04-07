<?php

namespace App\Http\Controllers\Agent\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.agent-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('agent')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $request->filled('remember'))) {
            return redirect()->intended(route('agent.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Invalid credentials or account not found.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::guard('agent')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('agent.login');
    }
}

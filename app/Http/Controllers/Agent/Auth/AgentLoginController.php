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
            'email_agent'    => 'required|email',
            'password_agent' => 'required|string',
        ]);

        if (Auth::guard('agent')->attempt([
            'email' => $request->email_agent,
            'password' => $request->password_agent,
        ], $request->filled('remember'))) {
            return redirect()->route('agent.dashboard');
        }

        return back()->withErrors([
            'email_agent' => 'Invalid credentials or account not found.',
        ])->withInput($request->only('email_agent'));
    }

    public function logout(Request $request)
    {
        Auth::guard('agent')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->to('/');
    }
}

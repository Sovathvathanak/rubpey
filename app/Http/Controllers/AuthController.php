<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('customer_id')) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'national_id' => ['required', 'string', 'max:20'],
            'pin' => ['required', 'string', 'min:4', 'max:20'],
        ]);

        $throttleKey = 'login:' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            return back()->withErrors(['national_id' => 'Too many attempts. Please try again in ' . RateLimiter::availableIn($throttleKey) . ' seconds.']);
        }

        $customer = $this->bank()->findCustomerByNationalId($validated['national_id']);

        if (! $customer || ! Hash::check($validated['pin'], $customer['pin_number'])) {
            RateLimiter::hit($throttleKey, 60);

            return back()->withErrors(['national_id' => 'The ID number or PIN is incorrect.'])->withInput($request->only('national_id'));
        }

        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();
        $request->session()->put('customer_id', $customer['customer_id']);
        $this->bank()->touchLastLogin($customer['customer_id']);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('customer_id');
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function showForgotPin()
    {
        return view('auth.forgot-pin');
    }

    public function verifyIdentity(Request $request)
    {
        $validated = $request->validate([
            'national_id' => ['required', 'string', 'max:20'],
            'phone' => ['required', 'string', 'max:20'],
        ]);

        $customer = $this->bank()->findCustomerByNationalId($validated['national_id']);
        $phoneMatches = $customer && preg_replace('/\D/', '', $customer['phone']) === preg_replace('/\D/', '', $validated['phone']);

        if (! $phoneMatches) {
            return back()->withErrors(['national_id' => 'We could not verify that ID number and phone number combination.'])->withInput();
        }

        session()->put('pin_reset', ['national_id' => $validated['national_id'], 'phone' => $validated['phone']]);

        return redirect()->route('password.reset');
    }

    public function showResetPin()
    {
        if (! session()->has('pin_reset')) {
            return redirect()->route('password.forgot');
        }

        return view('auth.reset-pin');
    }

    public function resetPin(Request $request)
    {
        $identity = session('pin_reset');
        if (! $identity) {
            return redirect()->route('password.forgot');
        }

        $validated = $request->validate([
            'pin' => ['required', 'string', 'min:4', 'max:20', 'confirmed'],
        ]);

        $this->bank()->updatePinByIdentity($identity['national_id'], $identity['phone'], $validated['pin']);
        session()->forget('pin_reset');

        return redirect()->route('login')->with('status', 'Your PIN has been reset. Sign in with your new PIN.');
    }
}

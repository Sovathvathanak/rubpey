<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showStep1()
    {
        return view('auth.register-step1', ['data' => session('register.step1', [])]);
    }

    public function postStep1(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:20'],
            'last_name' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:50'],
            'phone' => ['required', 'string', 'max:20'],
            'data_of_birth' => ['required', 'date', 'before:today'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        if ($this->bank()->emailExists($validated['email'])) {
            return back()->withErrors(['email' => 'This email address is already registered.'])->withInput();
        }

        session()->put('register.step1', $validated);

        return redirect()->route('register.step2');
    }

    public function showStep2()
    {
        if (! session()->has('register.step1')) {
            return redirect()->route('register');
        }

        return view('auth.register-step2', ['data' => session('register.step2', [])]);
    }

    public function postStep2(Request $request)
    {
        $validated = $request->validate([
            'national_id' => ['required', 'string', 'max:20'],
            'nationality' => ['required', 'string', 'max:20'],
            'id_image' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($this->bank()->findCustomerByNationalId($validated['national_id'])) {
            return back()->withErrors(['national_id' => 'This national ID is already registered.'])->withInput();
        }

        $imagePath = null;
        if ($request->hasFile('id_image')) {
            $imagePath = $request->file('id_image')->store('id-images', 'public');
        }

        session()->put('register.step2', [
            'national_id' => $validated['national_id'],
            'nationality' => $validated['nationality'],
            'image_path' => $imagePath,
        ]);

        return redirect()->route('register.step3');
    }

    public function showStep3()
    {
        if (! session()->has('register.step2')) {
            return redirect()->route('register');
        }

        return view('auth.register-step3');
    }

    public function postStep3(Request $request)
    {
        $step1 = session('register.step1');
        $step2 = session('register.step2');
        if (! $step1 || ! $step2) {
            return redirect()->route('register');
        }

        $validated = $request->validate([
            'pin' => ['required', 'string', 'min:4', 'max:12', 'confirmed'],
            'terms' => ['accepted'],
        ], [
            'terms.accepted' => 'You must agree to the Terms of Service and Privacy Policy.',
        ]);

        $customer = $this->bank()->createCustomer([
            ...$step1,
            ...$step2,
            'pin' => $validated['pin'],
        ]);

        session()->forget(['register.step1', 'register.step2']);
        session()->put('register.completed_code', $customer['customer_code']);
        session()->put('register.completed_id', $customer['customer_id']);

        return redirect()->route('register.complete');
    }

    public function complete()
    {
        if (! session()->has('register.completed_code')) {
            return redirect()->route('register');
        }

        return view('auth.register-complete', ['customerCode' => session('register.completed_code')]);
    }

    /** "Go to Dashboard" from the success screen signs the new customer in. */
    public function finish(Request $request)
    {
        $id = session('register.completed_id');
        if (! $id) {
            return redirect()->route('login');
        }

        $request->session()->regenerate();
        $request->session()->put('customer_id', $id);
        $request->session()->forget(['register.completed_code', 'register.completed_id']);

        return redirect()->route('dashboard');
    }
}

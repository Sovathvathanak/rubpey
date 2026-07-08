<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show', $this->shell());
    }

    public function settings()
    {
        return view('profile.settings', $this->shell());
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:20'],
            'last_name' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:50'],
            'phone' => ['required', 'string', 'max:20'],
        ]);

        $this->bank()->updateCustomer($this->customerId(), $validated);

        return redirect()->route('settings.index')->with('flash_success', 'Your changes have been saved.');
    }
}

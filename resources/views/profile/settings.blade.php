@extends('layouts.app')

@section('title', 'Settings')
@section('page-title', 'Settings & Preferences')

@section('content')
    <h2 class="text-3xl font-bold text-navy-900">Account Management</h2>
    <p class="mb-8 mt-1 text-sm text-slate-500">Review and update your personal credentials and system configuration.</p>

    <div class="card max-w-2xl overflow-hidden">
        <div class="flex items-center gap-3 border-b border-slate-100 px-8 py-5">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-100 text-brand-600">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" /></svg>
            </span>
            <h3 class="text-base font-bold text-navy-900">Personal Information</h3>
        </div>

        <form method="POST" action="{{ route('settings.update') }}">
            @csrf
            <div class="space-y-5 p-8">
                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div>
                        <label for="first_name" class="label">First Name</label>
                        <input id="first_name" name="first_name" type="text" value="{{ old('first_name', $customer['first_name']) }}" class="input" required>
                        @error('first_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="last_name" class="label">Last Name</label>
                        <input id="last_name" name="last_name" type="text" value="{{ old('last_name', $customer['last_name']) }}" class="input" required>
                        @error('last_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div>
                    <label for="email" class="label">Email Address</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /></svg>
                        </span>
                        <input id="email" name="email" type="email" value="{{ old('email', $customer['email']) }}" class="input pl-9" required>
                    </div>
                    @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="phone" class="label">Phone Number</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" /></svg>
                        </span>
                        <input id="phone" name="phone" type="tel" value="{{ old('phone', $customer['phone']) }}" class="input pl-9" required>
                    </div>
                    @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 border-t border-slate-100 bg-slate-50 px-8 py-4">
                <a href="{{ route('profile.show') }}" class="text-sm font-bold text-slate-600 hover:text-navy-900">Discard</a>
                <button type="submit" class="btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
@endsection

@extends('layouts.auth')

@section('title', 'Create Account')
@section('card-width', 'max-w-lg')

@section('card')
    <div class="flex items-center gap-2 px-8 pt-6 pb-4">
        @include('partials.logo', ['class' => 'h-8 w-8'])
        <span class="text-sm font-bold text-slate-900">RubPey</span>
    </div>
    @include('partials.register-progress', ['current' => 1])

    <div class="p-8">
        <h1 class="text-xl font-bold text-slate-900">Personal Information</h1>
        <p class="mb-6 mt-1 text-sm text-slate-500">Tell us about yourself to create your account.</p>

        <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="first_name" class="label">First Name</label>
                    <input id="first_name" name="first_name" type="text" value="{{ old('first_name', $data['first_name'] ?? '') }}" placeholder="Layhout" class="input" required autofocus>
                    @error('first_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="last_name" class="label">Last Name</label>
                    <input id="last_name" name="last_name" type="text" value="{{ old('last_name', $data['last_name'] ?? '') }}" placeholder="Tang" class="input" required>
                    @error('last_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label for="email" class="label">Email Address</label>
                <input id="email" name="email" type="email" value="{{ old('email', $data['email'] ?? '') }}" placeholder="you@email.com" class="input" required>
                @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="phone" class="label">Phone Number</label>
                <input id="phone" name="phone" type="tel" value="{{ old('phone', $data['phone'] ?? '') }}" placeholder="+855 000 000" class="input" required>
                @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="data_of_birth" class="label">Date of Birth</label>
                <input id="data_of_birth" name="data_of_birth" type="date" value="{{ old('data_of_birth', $data['data_of_birth'] ?? '') }}" class="input max-w-[200px]" required>
                @error('data_of_birth')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="address" class="label">Residential Address</label>
                <input id="address" name="address" type="text" value="{{ old('address', $data['address'] ?? '') }}" placeholder="Commune, District, City" class="input" required>
                @error('address')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="btn-primary w-full py-3">
                Continue
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
            </button>
        </form>
    </div>
@endsection

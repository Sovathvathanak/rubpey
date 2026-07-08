@extends('layouts.app')

@section('title', 'My Profile')
@section('page-title', 'Profile')

@section('content')
    {{-- Header --}}
    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-5">
            <span class="relative">
                <span class="flex h-20 w-20 items-center justify-center rounded-xl border border-slate-200 bg-white text-brand-600 shadow-sm">
                    <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                </span>
            </span>
            <div>
                <h2 class="text-3xl font-bold text-navy-900">{{ $customer['first_name'] }} {{ $customer['last_name'] }}</h2>
                <p class="mt-0.5 text-sm text-slate-500">ID: {{ $customer['customer_code'] }}</p>
            </div>
        </div>
        <a href="{{ route('settings.index') }}" class="btn-outline-brand">Edit Profile</a>
    </div>

    {{-- Personal details --}}
    <div class="card mb-6 p-8">
        <h3 class="flex items-center gap-2 border-b border-slate-100 pb-4 text-base font-bold text-navy-900">
            <svg class="h-5 w-5 text-brand-600" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" /></svg>
            Personal Details
        </h3>
        <dl class="mt-6 grid grid-cols-1 gap-x-12 gap-y-6 md:grid-cols-2">
            <div>
                <dt class="stat-label">Full Legal Name</dt>
                <dd class="mt-1 text-sm font-semibold text-navy-900">{{ $customer['first_name'] }} {{ $customer['last_name'] }}</dd>
            </div>
            <div>
                <dt class="stat-label">Customer ID</dt>
                <dd class="mt-1 font-mono text-sm font-semibold text-navy-900">{{ $customer['customer_code'] }}</dd>
            </div>
            <div>
                <dt class="stat-label">Date of Birth</dt>
                <dd class="mt-1 text-sm font-semibold text-navy-900">{{ \Carbon\Carbon::parse($customer['data_of_birth'])->format('M d, Y') }}</dd>
            </div>
            <div>
                <dt class="stat-label">Nationality</dt>
                <dd class="mt-1 text-sm font-semibold text-navy-900">{{ $customer['nationality'] }}</dd>
            </div>
            <div>
                <dt class="stat-label">National ID</dt>
                <dd class="mt-1 font-mono text-sm font-semibold text-navy-900">{{ $customer['national_id'] }}</dd>
            </div>
            <div>
                <dt class="stat-label">Member Since</dt>
                <dd class="mt-1 text-sm font-semibold text-navy-900">{{ \Carbon\Carbon::parse($customer['created_at'])->format('M d, Y') }}</dd>
            </div>
        </dl>
    </div>

    {{-- Contact info --}}
    <div class="card p-8">
        <h3 class="flex items-center gap-2 border-b border-slate-100 pb-4 text-base font-bold text-navy-900">
            <svg class="h-5 w-5 text-brand-600" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" /></svg>
            Contact Information
        </h3>
        <div class="mt-6 grid grid-cols-1 gap-8 md:grid-cols-3">
            <div class="flex items-start gap-3">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-100 text-brand-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" /></svg>
                </span>
                <div>
                    <span class="stat-label">Phone Number</span>
                    <p class="mt-1 text-sm font-semibold text-navy-900">{{ $customer['phone'] }}</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-100 text-brand-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /></svg>
                </span>
                <div>
                    <span class="stat-label">Email Address</span>
                    <p class="mt-1 text-sm font-semibold text-navy-900">{{ $customer['email'] }}</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-100 text-brand-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
                </span>
                <div>
                    <span class="stat-label">Residential Address</span>
                    <p class="mt-1 text-sm font-semibold text-navy-900">{{ $customer['address'] }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

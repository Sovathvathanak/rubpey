@extends('layouts.auth')

@section('title', 'ID Verification')
@section('card-width', 'max-w-lg')

@section('card')
    <div class="flex items-center gap-2 px-8 pt-6 pb-4">
        @include('partials.logo', ['class' => 'h-8 w-8'])
        <span class="text-sm font-bold text-slate-900">RubPey</span>
    </div>
    @include('partials.register-progress', ['current' => 2])

    <div class="p-8">
        <h1 class="text-xl font-bold text-slate-900">ID Verification</h1>
        <p class="mb-6 mt-1 text-sm text-slate-500">Verify your identity with a government-issued ID.</p>

        <form method="POST" action="{{ route('register.step2.post') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label for="national_id" class="label">National ID Number</label>
                <input id="national_id" name="national_id" type="text" value="{{ old('national_id', $data['national_id'] ?? '') }}" placeholder="000000000" class="input" required autofocus>
                @error('national_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="nationality" class="label">Nationality</label>
                <select id="nationality" name="nationality" class="input" required>
                    @foreach (['Cambodia', 'Thailand', 'Vietnam', 'Laos', 'Other'] as $nat)
                        <option value="{{ $nat }}" @selected(old('nationality', $data['nationality'] ?? 'Cambodia') === $nat)>{{ $nat }}</option>
                    @endforeach
                </select>
                @error('nationality')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="id_image" class="label">Upload ID Photo</label>
                <label for="id_image" class="flex cursor-pointer flex-col items-center justify-center gap-2 rounded-lg border-2 border-dashed border-slate-300 bg-slate-50 px-6 py-8 text-center transition hover:border-brand-500 hover:bg-brand-50">
                    <svg class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" /></svg>
                    <span class="text-sm font-medium text-slate-600">Click to upload the front of your ID</span>
                    <span class="text-xs text-slate-400">PNG or JPG, up to 4 MB (optional for demo)</span>
                    <span id="id-image-name" class="text-xs font-semibold text-brand-600"></span>
                </label>
                <input id="id_image" name="id_image" type="file" accept="image/*" class="hidden"
                       onchange="document.getElementById('id-image-name').textContent = this.files[0]?.name ?? ''">
                @error('id_image')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="flex gap-3 pt-2">
                <a href="{{ route('register') }}" class="btn-outline flex-1 py-3">Back</a>
                <button type="submit" class="btn-primary flex-1 py-3">
                    Continue
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                </button>
            </div>
        </form>
    </div>
@endsection

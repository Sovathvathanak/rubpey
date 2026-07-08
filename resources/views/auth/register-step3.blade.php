@extends('layouts.auth')

@section('title', 'Security Setup')
@section('card-width', 'max-w-lg')

@section('card')
    <div class="flex items-center gap-2 px-8 pt-6 pb-4">
        @include('partials.logo', ['class' => 'h-8 w-8'])
        <span class="text-sm font-bold text-slate-900">RubPey</span>
    </div>
    @include('partials.register-progress', ['current' => 3])

    <div class="p-8">
        <h1 class="text-xl font-bold text-slate-900">Security Setup</h1>
        <p class="mb-6 mt-1 text-sm text-slate-500">Create a strong PIN to protect your account.</p>

        <form method="POST" action="{{ route('register.step3.post') }}" class="space-y-4">
            @csrf
            <div>
                <label for="pin" class="label">PIN-Number</label>
                <input id="pin" name="pin" type="password" inputmode="numeric" placeholder="••••••••" class="input" required>
                @error('pin')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="rounded-xl border border-slate-200 bg-slate-50 p-5">
                <div class="mx-auto grid w-fit grid-cols-3 gap-3.5">
                    @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9] as $digit)
                        <button type="button" data-digit="{{ $digit }}"
                                class="keypad-btn h-11 w-11 rounded-full bg-brand-500/80 text-lg font-semibold text-white shadow transition hover:bg-brand-600 active:scale-95">{{ $digit }}</button>
                    @endforeach
                    <span></span>
                    <button type="button" data-digit="0"
                            class="keypad-btn h-11 w-11 rounded-full bg-brand-500/80 text-lg font-semibold text-white shadow transition hover:bg-brand-600 active:scale-95">0</button>
                    <button type="button" id="keypad-back"
                            class="flex h-11 w-11 items-center justify-center rounded-full bg-brand-500/80 text-white shadow transition hover:bg-red-500 active:scale-95">
                        <svg class="h-5 w-5 text-red-100" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75 14.25 12m0 0 2.25 2.25M14.25 12l2.25-2.25M14.25 12 12 14.25m-2.58 4.92-6.374-6.375a1.125 1.125 0 0 1 0-1.59L9.42 4.83c.21-.211.497-.33.795-.33H19.5a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25h-9.284c-.298 0-.585-.119-.795-.33Z" /></svg>
                    </button>
                </div>
            </div>

            <div>
                <label for="pin_confirmation" class="label">Confirm PIN Number</label>
                <input id="pin_confirmation" name="pin_confirmation" type="password" inputmode="numeric" placeholder="Re-enter your PIN Number" class="input" required>
            </div>

            <label class="flex items-center gap-2 text-xs text-slate-600">
                <input type="checkbox" name="terms" value="1" class="h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500" @checked(old('terms'))>
                <span>I agree to the <a href="#" class="font-semibold text-brand-600">Terms of Service</a> and <a href="#" class="font-semibold text-brand-600">Privacy Policy</a></span>
            </label>
            @error('terms')<p class="text-xs text-red-600">{{ $message }}</p>@enderror

            <div class="flex gap-3 pt-2">
                <a href="{{ route('register.step2') }}" class="btn-outline flex-1 py-3">Back</a>
                <button type="submit" class="btn-primary flex-1 py-3">Create Account</button>
            </div>
        </form>
    </div>

    <script>
        // Keypad types into whichever PIN field was focused last (defaults to the first).
        let pinTarget = document.getElementById('pin');
        ['pin', 'pin_confirmation'].forEach(id => {
            document.getElementById(id).addEventListener('focus', e => pinTarget = e.target);
        });
        document.querySelectorAll('.keypad-btn').forEach(btn => {
            btn.addEventListener('click', () => { pinTarget.value += btn.dataset.digit; });
        });
        document.getElementById('keypad-back').addEventListener('click', () => {
            pinTarget.value = pinTarget.value.slice(0, -1);
        });
    </script>
@endsection

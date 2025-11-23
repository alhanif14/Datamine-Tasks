<x-guest-layout>

    {{-- REGISTER FORM --}}
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full"
                type="text" name="name" :value="old('name')" required autofocus />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full"
                type="email" name="email" required />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                type="password" name="password" required />
        </div>

        <!-- Confirm -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                type="password" name="password_confirmation" required />
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                Already registered?
            </a>

            <x-primary-button>
                Register
            </x-primary-button>
        </div>
    </form>

    {{-- GOOGLE LOGIN BUTTON --}}
    <div class="mt-6">
        <a href="{{ route('google.redirect') }}"
            class="w-full flex items-center gap-2 justify-center py-2 border rounded-lg hover:bg-gray-50 transition">
            
            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" class="w-5">
            <span>Register with Google</span>
        </a>
    </div>

</x-guest-layout>

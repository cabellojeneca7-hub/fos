<x-app-layout>
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Cashier</h1>
            <p class="text-gray-500">Update cashier account details.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="bg-gray-100 text-gray-800 px-6 py-3 rounded-2xl font-bold shadow-sm flex items-center space-x-2 active:scale-95 transition">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Back</span>
        </a>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm overflow-hidden border border-gray-100 max-w-2xl">
        <div class="p-8">
            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PATCH')

                <!-- Name -->
                <div class="mb-6">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full bg-gray-50 border-none rounded-xl py-3 px-4 focus:ring-2 focus:ring-blue-500 shadow-inner" type="text" name="name" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mb-6">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full bg-gray-50 border-none rounded-xl py-3 px-4 focus:ring-2 focus:ring-blue-500 shadow-inner" type="email" name="email" :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <x-input-label for="password" :value="__('New Password (leave blank to keep current)')" />
                    <x-text-input id="password" class="block mt-1 w-full bg-gray-50 border-none rounded-xl py-3 px-4 focus:ring-2 focus:ring-blue-500 shadow-inner" type="password" name="password" autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <x-input-label for="password_confirmation" :value="__('Confirm New Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-50 border-none rounded-xl py-3 px-4 focus:ring-2 focus:ring-blue-500 shadow-inner" type="password" name="password_confirmation" autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-8">
                    <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-2xl font-bold shadow-lg shadow-blue-200 active:scale-95 transition">
                        {{ __('Update Cashier') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
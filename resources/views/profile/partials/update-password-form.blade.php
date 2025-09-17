<div class="bg-white rounded shadow p-6">
    <header>
        <h2 class="text-gray-800 text-xl font-semibold">
            {{ __('Ubah Kata Sandi') }}
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-4">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700">
                {{ __('Kata Sandi Saat Ini') }}
            </label>
            <input id="update_password_current_password" name="current_password" type="password"
                class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 mt-2"
                autocomplete="current-password" />
            @error('current_password', 'updatePassword')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-medium text-gray-700">
                {{ __('Kata Sandi Baru') }}
            </label>
            <input id="update_password_password" name="password" type="password"
                class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 mt-2"
                autocomplete="new-password" />
            @error('password', 'updatePassword')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700">
                {{ __('Konfirmasi Kata Sandi') }}
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 mt-2"
                autocomplete="new-password" />
            @error('password_confirmation', 'updatePassword')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none">
                {{ __('Simpan') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Disimpan.') }}</p>
            @endif
        </div>
    </form>
</div>

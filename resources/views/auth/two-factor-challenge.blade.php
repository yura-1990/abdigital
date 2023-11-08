<x-guest-layout>
    <div class="mb-4 text-[22px] font-semibold text-gray-600">
        {{ __('2Fa password.') }}
    </div>

    <form method="POST" action="{{ route('two-factor.login') }}" >
        @csrf
        <div class="code active">
            <x-input-label for="code" :value="__('Code')" />
            <x-text-input id="code" class="block mt-1 w-full"
                          type="number"
                          name="code"
                          autocomplete="current-code" />

            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <div class="recovery_code">
            <x-input-label for="recovery_code" :value="__('Recovery Code')" />

            <x-text-input id="recovery_code" class="block mt-1 w-full"
                          type="text"
                          name="recovery_code"
                          autocomplete="current-recovery_code" />

            <x-input-error :messages="$errors->get('recovery_code')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

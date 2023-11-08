<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Swagger') }}
            </h2>
            @if(!auth()->user()->two_factor_secret)
                <p class="font-semibold text-red-600 bg-indigo-50 w-full p-4 rounded">
                    You have to finish your 2fa authentication!
                    To finish go to <a class="text-green-600" href="{{ route('profile.edit') }}">your profile</a>
                </p>
            @endif
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div id="swagger-api"></div>
            </div>
        </div>
    </div>
</x-app-layout>

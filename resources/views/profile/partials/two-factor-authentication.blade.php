<section>
    <header>
        <h2 class="text-xl mb-4 font-bold text-gray-900">
            {{ __('Two-Factor Authentication ') }}
        </h2>

        @if(auth()->user()->two_factor_secret)
            <p>{{ __('What is Two-Factor Authentication (2FA)?') }}</p>
            <p class="mt-1 text-sm text-gray-600">{{ __('Two-Factor Authentication (2FA) is an extra layer of security that helps protect your online accounts, including your website, from unauthorized access. It requires you to provide two forms of identification: something you know (your password) and something you have (a temporary code from an app or a text message).') }}</p>
            <br>

            <p>{{ __('Setting Up 2FA with Google Authenticator:') }}</p>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Download Google Authenticator: Before setting up 2FA, users need to download the Google Authenticator app from their device`s app store. It`s available for both ') }}
                <a class="font-semibold text-green-600" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=ru&gl=US">{{ __('Android ') }}</a>
                {{ __('and') }}
                <a class="font-semibold text-green-600" href="https://apps.apple.com/ru/app/google-authenticator/id388497605">{{ __('iOS.') }}</a>
            </p>


            <br>

            <p>{{ __('Scan the QR Code:') }}</p>
            <p class="mt-1 text-sm text-gray-600">{{ __('When enabling 2FA, your website will show a QR code on the screen. In the Google Authenticator app, users should tap the "+" or "Add" button and then select "Scan a barcode." They should use their phone`s camera to scan the QR code displayed on your website.') }}</p>
            <p>OR</p>

            <p>{{ __('Enter a Recovery Code:') }}</p>
            <p class="mt-1 text-sm text-gray-600">{{ __('You`ll be prompted to enter one of your recovery codes. These codes are typically one-time use, so be sure to mark them as used after you`ve successfully logged in.') }}</p>
            <br>
            <p>{{ __('Important Tips:') }}</p>
            <p class="mt-1 text-sm text-gray-600">{{ __('Keep recovery codes in a safe place, separate from your primary 2FA device.') }}</p>
            <p class="mt-1 text-sm text-gray-600">{{ __('Do not share recovery codes with anyone. They are for your use only.') }}</p>
            <p class="mt-1 text-sm text-gray-600">{{ __('If you use a recovery code to access your account, consider updating your 2FA settings and generating new recovery codes afterward.') }}</p>
            <br>
        @else
            <p class="mt-1 text-sm text-gray-600">
                {{ __('You should confirm 2fa authentication.') }}
            </p>
        @endif

    </header>

    @if (session('status') == 'two-factor-authentication-enabled')
        <div class="mb-4 p-4 bg-indigo-50 font-medium text-sm">
            Please finish configuring two-factor authentication below.
        </div>
    @endif

    @if (session('status') == 'two-factor-authentication-disabled')
        <div class="mb-4 p-4 bg-indigo-50 font-medium text-sm">
            Two-factor authentication disabled.
        </div>
    @endif

    @if (session('status') == 'two-factor-authentication-confirmed')
        <div class="mb-4 font-medium text-sm">
            Two factor authentication confirmed and enabled successfully.
        </div>
    @endif

    <form method="post" action="/user/two-factor-authentication" class="mt-6 space-y-6">
        @csrf

        @if(auth()->user()->two_factor_secret)
            @method("DELETE")

            <div class="flex gap-[50px] w-full">
                <div class="">
                    {!! auth()->user()->twoFactorQrCodeSvg() !!}
                </div>

                <div class="flex flex-col gap-2">
                    <h3 class="font-semibold">{{ __("Recovery Codes") }}</h3>
                    <ul>
                        @foreach(auth()->user()->recoveryCodes() as $code)
                            <li class="text-sm">{{ $code }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Disable') }}</x-primary-button>
            </div>
        @else
            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Enable') }}</x-primary-button>
                <p class="show"> 👈 </p>
            </div>
        @endif
    </form>

</section>

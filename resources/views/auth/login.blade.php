<x-guest-layout :isReactAuth="true">
    @php
        $loginErrors = [];
        if ($errors->any()) {
            foreach ($errors->all() as $error) {
                $loginErrors['email'] = $error;
                break;
            }
        }
    @endphp

    <div id="login-app"
         data-csrf="{{ csrf_token() }}"
         data-old-email="{{ old('email') }}"
         data-errors="{{ json_encode($loginErrors) }}"
         data-status="{{ session('status') }}">
    </div>
</x-guest-layout>

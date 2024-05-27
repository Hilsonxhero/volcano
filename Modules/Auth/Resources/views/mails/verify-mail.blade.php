<x-mail::message>

#  کد تایید ایمیل حساب کاربری
##  برای تایید ایمیل از کد زیر استفاده کنید :


{{-- <x-mail::button>
    {{ $code }}
</x-mail::button> --}}

<x-mail::panel>
    {{ $code }}
</x-mail::panel>

<x-mail::subcopy>
    با احترام,
</x-mail::subcopy>

{{ config('app.name') }}
</x-mail::message>

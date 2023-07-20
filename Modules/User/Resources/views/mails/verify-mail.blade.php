@extends('mail::layouts.master')

@section('content')
    <div class="container">
        <h1>
            کد تایید تغییر ایمیل حساب کاربری
        </h1>
        <p>
            کاربر گرامی
        </p>
        <p>
        <p>
            برای تایید تغییر ایمیل از کد زیر استفاده کنید :
        </p>
        </p>
        <div class="code">
            {{ $code }}
        </div>
        <p>اگر این کد را درخواست نکردید، لطفاً این ایمیل را نادیده بگیرید</p>
        <p>با احترام,</p>
        <p>
            {{ config('app.name') }}
        </p>

    </div>
@endsection

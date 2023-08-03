@extends('mail::layouts.master')

@section('content')
    <div class="container">
        <h1>
            پاسخ پیام شما
        </h1>
        <p>
            کاربر گرامی
        </p>
        <p>
        <p>
            {{ $message_data['content'] }}
        </p>
        <hr />
        </p>
        </p>
        <p>
            {{ $message_data['answer'] }}
        </p>
        </p>
        <p>
            {{ config('app.name') }}
        </p>

    </div>
@endsection

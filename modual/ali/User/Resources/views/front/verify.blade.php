@extends('User::front.master')

@section('content')
    <form action="{{route('verification.verify')}}" class="form" method="post">
        @csrf
        <a class="account-logo" href="/">
            <img src="img/weblogo.png" alt="">
        </a>
        <div class="card-header">
            <p class="activation-code-title">کد فرستاده شده به شماره <span>{{$mobile}}</span>
                را تایید کنید
            </p>
        </div>
        <div class="form-content form-content1">
            <input name="verify_code" required class="activation-code-input" placeholder="فعال سازی">
            <br>
            @error('verify_code')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            @if(session()->has('message'))
                <span class="invalid-feedback" role="alert">
                                <strong>{{ session()->get('message') }}</strong>
                 </span>
            @endif

            <button class="btn i-t">تایید</button>
            <a href="#" onclick="
            event.preventDefault();
            document.getElementById('resend-conde').submit();">
                ارسال مجدد کد فعالسازی
            </a>
        </div>
        <div class="form-footer">
            <a href="{{route('register')}}">صفحه ثبت نام</a>
        </div>
    </form>

    <form id="resend-conde" action="{{route('verification.resend')}}" method="post">

        @csrf

    </form>

@endsection

@section('js')

    <script src="/js/jquery-3.4.1.min.js"></script>
    <script src="/js/activation-code.js"></script>

@endsection

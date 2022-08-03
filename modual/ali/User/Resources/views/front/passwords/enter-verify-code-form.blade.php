@extends('User::front.master')

@section('content')
    <form action="{{route('password.checkVerifyCode')}}" class="form" method="post">
        @csrf
        {{--       {{dd( $errors)}}--}}
        <input type="hidden" name="mobile" value="{{request()->mobile}}">
        <a class="account-logo" href="/">
            <img src="img/weblogo.png" alt="">
        </a>

        <div class="card-header">
            <p class="activation-code-title">کد فرستاده شده به تلفن همراه <span>{{request()->mobile}}</span>
                را وارد کنید
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
            <a href="{{route("password.sendVerifyCodeEmail")}}?mobile={{request()->mobile}}">
                ارسال مجدد کد فعالسازی
            </a>

        </div>
        <div class="form-footer">
            <a href="{{route('register')}}">صفحه ثبت نام</a>
        </div>
    </form>


@endsection

@section('js')

    <script src="/js/jquery-3.4.1.min.js"></script>
    <script src="/js/activation-code.js"></script>

@endsection

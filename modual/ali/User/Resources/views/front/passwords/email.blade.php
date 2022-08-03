@extends('User::front.master')

@section('content')
    <form method="get" action="{{route('password.sendVerifyCodeEmail')}}" class="form">
        <a class="account-logo" href="/">
            <img src="/img/weblogo.png" alt="">
        </a>
        <div class="form-content form-account">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <input style="direction: ltr"
                   type="text"
                   name="mobile" id="mobile"
                   class="txt-l txt @error('mobile') is-invalid @enderror"
                   placeholder="تلفن همراه (9127654321)"
                   value="{{ old('mobile') }}" required autocomplete="mobile" autofocus
            >
            @error('mobile')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <br>
            <button type="submit" class="btn btn-recoverpass">بازیابی</button>
        </div>
        <div class="form-footer">
            <a href="{{route('login')}}">صفحه ورود</a>
        </div>
    </form>
@endsection

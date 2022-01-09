@component('mail::message')
    # کد بازیابی رمز عبور حساب شما در ممتاز

 این ایمیل به درخواست شما جهت بازیابی رمز عبور در سایت ممتاز برای شما ارسال شده است. **در صورتی که این درخواست توسط شما انجام نشده است** این ایمیل را نادیده بگیرید.

@component('mail::panel')
کد فعال سازی شما :{{$code}}
@endcomponent

    با تشکر,<br>
    {{ config('app.name') }}
@endcomponent


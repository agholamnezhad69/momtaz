@component('mail::message')
# کد فعال سازی شما در سایت ممتاز

این ایمیل به دلیل ثبت نام شما در سایت ممتاز برای شما ارسال شده است **در صورتی کمه ثبت نامی برای شما انجام نشده است** این ایمیل را نادیده بگیرید

@component('mail::panel')
کد فعال سازی شما :{{$code}}
@endcomponent

با تشکر<br>
{{ config('app.name') }}
@endcomponent
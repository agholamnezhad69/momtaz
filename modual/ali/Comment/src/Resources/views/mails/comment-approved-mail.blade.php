@component('mail::message')
# یک کامنت جدید برای دوره ی"{{ $comment->commentable->title }}" تایید شده است.
مدرس گرامی یک کامنت جدید برای دوره ی"{{ $comment->commentable->title }}" در سایت ممتاز تایید است. لطفا در اسرع وقت پاسخ مناسب ارسال فرمایید.
@component('mail::panel')
@component('mail::button', ['url' => $comment->commentable->path()])
مشاهده دوره
@endcomponent
@endcomponent

با تشکر,{{ config('app.name') }}
@endcomponent

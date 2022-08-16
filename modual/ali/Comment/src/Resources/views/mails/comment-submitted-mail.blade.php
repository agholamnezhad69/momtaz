@component('mail::message')
@if($comment->user->can('replies', $comment))
# یک کامنت جدید برای دوره ی"{{ $comment->commentable->title }}" ارسال شده است.
مدرس گرامی یک کامنت جدید برای دوره ی"{{ $comment->commentable->title }}" در سایت ممتاز ارسال شده است. لطفا در اسرع وقت پاسخ مناسب ارسال فرمایید.
@else
# یک کامنت جدید برای دوره ی"{{ $comment->commentable->title }}"ارسال شده است.
کاربر گرامی یک پاسخ جدید برای دوره ی"{{ $comment->commentable->title }}" در سایت ممتاز ارسال شده است. لطفا در اسرع وقت مشاهده بفرمائید.
@endif
@component('mail::panel')
@component('mail::button', ['url' => $comment->commentable->path()])
مشاهده دوره
@endcomponent
@endcomponent

با تشکر,{{ config('app.name') }}
@endcomponent

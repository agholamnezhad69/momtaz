@component('mail::message')
# کامنت شما برای دوره ی"{{ $comment->commentable->title }}" رد شده است.
@component('mail::panel')
@component('mail::button', ['url' => $comment->commentable->path()])
مشاهده دوره
@endcomponent
@endcomponent
با تشکر,{{ config('app.name') }}
@endcomponent

@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{route('comments.index')}}" title="نظرات">نظرات</a></li>
    <li><a href="{{route('comments.show',$comment->id)}}" class="is-active"> مشاهده نظر</a></li>

@endsection


@section('content')

    <div class="main-content">
        <div class="show-comment">
            <div class="ct__header">
                <div class="comment-info">
                    <a class="back" href="{{route("comments.index")}}"></a>
                    <div>
                        <p class="comment-name"><a href="">{{$comment->commentable->title}}</a></p>
                    </div>
                </div>
            </div>

            @include("Comment::comment",["isAnswer"=>false])
            @foreach($comment->replies as $reply)
                @include("Comment::comment",["comment"=>$reply,"isAnswer"=>true])
            @endforeach
        </div>
        @if($comment->status == \ali\Comment\Models\Comment::STATUS_APPROVED)
            <div class="answer-comment">
                <p class="p-answer-comment">ارسال پاسخ</p>
                <form action="{{route('comments.store')}}" method="post">
                    @csrf
                    <input type="hidden" name="commentable_type" value="{{get_class($comment->commentable)}}">
                    <input type="hidden" name="commentable_id" value="{{$comment->commentable->id}}">
                    <input type="hidden" name="comment_id" value="{{$comment->id}}">
                    <x-TextArea name="body" placeholder="متن پاسخ نظر.........."/>
                    <button class="btn btn-brand">ارسال پاسخ</button>
                </form>
            </div>
        @else
            <p class="comment-alert">برای ارسال پاسخ  کامنت باید تایید بشود </p>
        @endif
    </div>

@endsection



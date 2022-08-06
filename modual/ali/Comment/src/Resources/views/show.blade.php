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
        <div class="answer-comment">
            <p class="p-answer-comment">ارسال پاسخ</p>
            <form action="" method="post">
                <textarea class="textarea" placeholder="متن پاسخ نظر"></textarea>
                <button class="btn btn-brand">ارسال پاسخ</button>
            </form>
        </div>
    </div>

@endsection



@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{route('tickets.index')}}" title="تیکت ها">تیکت ها</a></li>
    <li><a href="" title="تیکت ها">نمایش تیکت</a></li>
@endsection


@section('content')
    <div class="main-content">
        <div class="show-comment">
            <div class="ct__header">
                <div class="comment-info">
                    <a class="back" href="{{route('tickets.index')}}"></a>
                    <div>
                        <p class="comment-name"><a href="">{{$ticket->title}}</a></p>
                    </div>
                </div>
            </div>

            @foreach($ticket->ticketReplies as $reply)
                <div class="transition-comment {{$reply->user_id == $ticket->user_id ? "":"is-answer"}}">
                    <div class="transition-comment-header">
                       <span>
                            <img src="{{$reply->user->Thumb}}" class="logo-pic">
                       </span>
                        <span class="nav-comment-status">
                            <p class="username">کاربر :{{$reply->user->name}}</p>
                            <p class="comment-date">{{$reply->user->created_at}}</p></span>
                        <div>

                        </div>
                    </div>
                    <div class="transition-comment-body">
                        <pre>
                            {!!$reply->body !!}
                        </pre>
                        <div>

                        </div>
                    </div>
                </div>
            @endforeach


        </div>
        <div class="answer-comment">
            <p class="p-answer-comment">ارسال پاسخ</p>
            <form action="{{route('tickets.reply',$ticket->id)}}" method="post" enctype="multipart/form-data" class="padding-30">
                @csrf
                <x-textarea placeholder="متن تیکت" name="body" class="text" required/>

                <x-file name="attachment" placeholder="آپلود فایل پیوست"/>

                <button class="btn btn-brand">ایجاد تیکت</button>
            </form>
        </div>
    </div>
@endsection











<div class="transition-comment {{$isAnswer? "is-answer":""}}">
    <div class="transition-comment-header">
                       <span>
                                         <img src="{{$comment->user->thumb}}" class="logo-pic" alt="{{$comment->user->name}}">
                       </span>
                     <span class="nav-comment-status">
                            <p class="username">{{ $comment->user->name}}</p>
                            <p class="comment-date">{{$comment->created_at->diffForHumans()}}</p>
                     </span>
        <div>

        </div>
    </div>
    <div class="transition-comment-body">
        <pre>{{ $comment->body}} </pre>
    </div>
    <div class="comment-actions">
        <a
            href=""
            onclick="deleteItem(event,'{{route('comments.destroy',$comment->id)}}')"
            class="item-delete mlg-15"
            title="حذف">
        </a>
        <a href=""
           onclick="updateConfirmationStatus(event,'{{route('comments.accept',$comment->id)}}',
               'آیا از تایید این مورد اطمینان دارید؟',
               '@lang(\ali\Comment\Models\Comment::STATUS_APPROVED)')"
           class="item-confirm mlg-15" title="تایید">

        </a>
        <a href=""
           onclick="updateConfirmationStatus(event,'{{route('comments.reject',$comment->id)}}',
               'آیا از رد شدن این مورد اطمینان دارید؟',
               '@lang(\ali\Comment\Models\Comment::STATUS_REJECT)')"
           class="item-reject mlg-15" title="رد">

        </a>
    </div>

</div>

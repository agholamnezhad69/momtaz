<div id="Modal2" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <p>ارسال پاسخ</p>
            <div class="close">&times;</div>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('comments.store')}}">
                @csrf
                <input type="hidden" name="comment_id" value="" id="comment_id">
                <input type="hidden" name="commentable_type" value="{{get_class($commentable)}}">
                <input type="hidden" name="commentable_id" value="{{$commentable->id}}">

                <x-TextArea name="body" placeholder="متن دیدگاه.........."/>
                <button class="btn i-t">ثبت پاسخ</button>
            </form>
        </div>

    </div>
</div>

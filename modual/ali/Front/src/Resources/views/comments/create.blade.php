<div class="comment-main">
    <div class="ct-header">
        <h3>نظرات ( 180 )</h3>
        <p>نظر خود را در مورد این مقاله مطرح کنید</p>
    </div>
    <form action="{{route('comments.store',$course->id)}}" method="post">
        @csrf
        <div class="ct-row">
            <div class="ct-textarea">
                <x-TextArea name="body" placeholder="ارسال نظر.........."/>
            </div>
        </div>
        <div class="ct-row">
            <div class="send-comment">
                <button type="submit" class="btn i-t">ثبت نظر</button>
            </div>
        </div>

    </form>
</div>

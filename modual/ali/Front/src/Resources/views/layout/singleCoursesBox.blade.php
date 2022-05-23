<div class="col">
    <a href="{{$courseItem->path()}}">
        <div class="course-status">
            @lang($courseItem->confirmation_status)
        </div>
        @if($courseItem->getDiscountPercent())
            <div class="discountBadge">
                <p>{{$courseItem->getDiscountPercent()}}%</p>
                تخفیف
            </div>
        @endif
        <div class="card-img"><img src="{{$courseItem->banner->Thumb}}" alt="reactjs"></div>
        <div class="card-title"><h2>{{$courseItem->title}}</h2></div>
        <div class="card-body">
            <img src="{{$courseItem->teacher->Thumb}}" alt="محمد نیکو">
            <span>{{$courseItem->teacher->name}}</span>
        </div>
        <div class="card-details">
            <div class="time">{{$courseItem->formattedDuration()}}</div>
            <div class="price">
                @if($courseItem->getDiscountPercent())
                    <div class="discountPrice">{{$courseItem->getFormattedPrice()}}</div>
                @endif
                <div class="endPrice">{{$courseItem->getFormattedFinalPrice()}}</div>
            </div>
        </div>
    </a>
</div>

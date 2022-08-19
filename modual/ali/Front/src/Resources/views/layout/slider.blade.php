<div class="slideshow">
    @foreach($slides as $slide)
        <div class="slide">
            @if($slide->link)
                <a href="{{ $slide->link }}" >
                    @endif
                    <img src="{{ $slide->media->getUrl() }}" alt="">
                    @if($slide->link)
                </a>
            @endif
        </div>

    @endforeach

    <a class="prev" onclick="move(-1)"><span>&#10095</span></a>
    <a class="next" onclick="move(1)"><span>&#10094</span></a>

    <div class="items">
        @foreach($slides as $slide)
            <div class="item">
                <div class="item-inner"></div>
            </div>
        @endforeach
    </div>
</div>

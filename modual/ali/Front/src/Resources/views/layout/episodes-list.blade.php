<div class="episodes-list">
    <div class="episodes-list--title">
        فهرست جلسات
        @can('download',$course)
            <span>

            <a href="{{route('courses.downloadLinks',$course->id)}}">دریافت همه لینک های دانلود</a>

            </span>
        @endcan

    </div>
    <div class="episodes-list-section">

        @foreach($lessons as $lesson)

            {{--            @can('download', $lesson)--}}
            {{--            <div class="episodes-list-item     ">--}}
            {{--            @else--}}
            {{--             <div class="episodes-list-item lock">--}}
            {{--             @endcan--}}

            <div
                class="episodes-list-item
                @can("download",$lesson)
                @else
                @if($lesson->is_free)
                @else
                    lock
                @endif

                @endcannot">
                <div class="section-right">
                    <span class="episodes-list-number">{{$lesson->number}}</span>
                    <div class="episodes-list-title">
                        <a
                            @if($lesson->is_free)
                            href="{{$lesson->path()}}"
                            @else
                            @can("download", $lesson)
                            href="{{$lesson->path()}}"
                        @endcan
                        @endif


                        ">{{$lesson->title}}</a>
                    </div>
                </div>
                <div class="section-left">
                    <div class="episodes-list-details">
                        <div class="episodes-list-details">
                            <span class="detail-type">{{$lesson->is_free()}}</span>
                            <span class="detail-time">{{$lesson->time}} دقیقه</span>
                            <a
                                class="detail-download"
                                @if($lesson->is_free)
                                href="{{$lesson->downloadLink()}}"
                                @else
                                @can("download", $lesson)
                                href="{{$lesson->downloadLink()}}"
                                @endcan
                                @endif
                            >


                                <i class="icon-download"></i>


                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

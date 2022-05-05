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
            {{-- <div class="episodes-list-item lock"> --}}
            <div
                class="episodes-list-item @cannot("download",$lesson)  lock  @endcannot">
                <div class="section-right">
                    <span class="episodes-list-number">{{$lesson->number}}</span>
                    <div class="episodes-list-title">
                        <a href="{{$lesson->path()}}">{{$lesson->title}}</a>
                    </div>
                </div>
                <div class="section-left">
                    <div class="episodes-list-details">
                        <div class="episodes-list-details">
                            <span class="detail-type">{{$lesson->is_free()}}</span>
                            <span class="detail-time">{{$lesson->time}} دقیقه</span>
                            <a @can("download",$lesson) href="{{$lesson->downloadLink()}}"
                               @endcan class="detail-download">
                                <i class="icon-download"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

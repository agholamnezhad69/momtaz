@extends('Front::layout.master')
@section('content')
    <main id="single" class="mrt-150">
        <div class="content">
            <div class="container">
                <article class="article">
                    @include('Front::layout.header-ads')
                    <div class="h-t">
                        <h1 class="title">{{$course->title}}</h1>

                        <div class="breadcrumb">
                            <ul>
                                @if($course->category->parentCategory)
                                    <li><a href="{{$course->category->parentCategory->path()}}"
                                           title="خانه">{{$course->category->parentCategory->title}}</a></li>
                                @endif
                                <li><a href="{{$course->category->path()}}"
                                       title="برنامه نویسی">{{$course->category->title}}</a></li>

                                <li><a href="" title="{{$course->path()}}">{{$course->title}}</a></li>
                                
                            </ul>
                        </div>
                    </div>
                </article>
            </div>

        </div>
    </main>


@endsection

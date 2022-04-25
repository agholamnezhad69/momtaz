@extends('Front::layout.master')
@section('content')
    <main id="index">
        <div class="bt-0-top article mr-202"></div>
        <div class="bt-1-top">
            <div class="container">
                <div class="tutor">
                    <div class="tutor-item">
                        <div class="tutor-avatar">
                            <span class="tutor-image" id="tutor-image"><img src="{{$teacher->thumb}}"
                                                                            class="tutor-avatar-img"></span>
                            <div class="tutor-author-name">
                                <a id="tutor-author-name" href="" title="{{$teacher->name}}">
                                    <h3 class="title"><span class="tutor-author--name">{{$teacher->name}}</span></h3>
                                </a>
                            </div>
                            <div id="Modal1" class="modal">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="close">&times;</div>
                                    </div>
                                    <div class="modal-body">
                                        <img class="tutor--avatar--img" src="" alt="">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tutor-item">
                        <div class="stat">
                            <span class="tutor-number tutor-count-courses">{{count( $teacher->courses)}}</span>
                            <span class="">تعداد دوره ها</span>
                        </div>
                        <div class="stat">

                            <span class="tutor-number">{{$teacher->studentCount()}}</span>
                            <span class="">تعداد  دانشجویان</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="box-filter">
                <div class="b-head">
                    <h2>دوره های {{$teacher->name}}</h2>
                </div>
                <div class="posts">
                    @foreach($teacher->courses as $courseItem)
                        @include('Front::layout.singleCoursesBox')
                    @endforeach

                </div>
            </div>


            <div class="pagination">
                <a href="" class="pg-prev"></a>
                <a href="" class="page current">1</a>
                <a href="" class="page ">2</a>
                <a href="" class="page ">3</a>
                <a href="" class="page ">4</a>
                <a href="" class="page ">5</a>
                <a href="" class="page ">6</a>
                <a href="" class="page ">7</a>
                <a href="" class="page ">...</a>
                <a href="" class="page ">100</a>
                <a href="" class="pg-next"></a>
            </div>
        </div>
    </main>
@endsection

@section('css')
    <link rel="stylesheet" href="/css/modal.css">
@endsection

@section('js')
    <script src="/js/modal.js"></script>
@endsection



@extends("Dashboard::master")

@section('breadcrumb')
    <li><a href="{{route('courses.details',$season->course_id)}}" title="سرفصل ها">سرفصل ها</a></li>
    <li><a href="#" title=" ویرایش سرفصل"> ویرایش سرفصل</a></li>
@endsection

@section('content')
    <div class="row no-gutters  ">
        <div class="col-12 bg-white">
            <p class="box__title">ایجاد سرفصل</p>
            <form action="{{route('seasons.update',$season->id)}}" class="padding-30" method="post">
                <x-input name="title" type="text" value="{{$season->title}}" placeholder="عنوان سرفصل" class="text"/>
                <x-input name="number" type="text" value="{{$season->number}}" placeholder="شماره سرفصل" class="text"/>
                @csrf
                @method('patch')


                <button type="submit" class="btn btn-webamooz_net mt-2">بروز رسانی</button>
            </form>
        </div>
    </div>
@endsection


@section('js')
    <script src="/panel/js/tagsInput.js"></script>

    <script>
        @include("Common::layouts.feedbacks")
    </script>
@endsection
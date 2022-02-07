@extends("Dashboard::master")

@section('breadcrumb')
    <li><a href="{{route('courses.index')}}" title="دوره">دوره ها</a></li>
    <li><a href="{{route('courses.details',$course->id)}}" title="{{$course->title}}">{{$course->title}}</a></li>
    <li><a href="#" title=" ایجاد دوره"> بروزرسانی جلسه</a></li>
@endsection

@section('content')
    <div class="row no-gutters">
        <div class="col-12 bg-white">
            <p class="box__title">بروزرسانی جلسه</p>
            <form action="{{route('lessons.update',[$course->id,$lesson->id])}}"
                  class="padding-30" method="post"
                  enctype="multipart/form-data">

                @csrf
                @method('patch')

                <x-input name="title" type="text" placeholder="عنوان جلسه جدید * " value="{{$lesson->title}}" required/>

                <x-input type="text" name="slug" class="text-left" value="{{$lesson->slug}}"
                         placeholder="  نام انگلیسی درس اختیاری"/>
                <x-input type="number" name="time" class="text-left" value="{{$lesson->time}}"
                         placeholder="مدت زمان جلسه *" required/>
                <x-input type="number" name="number" class="text-left" value="{{$lesson->number}}"
                         placeholder="شماره جلسه"/>
                @if(count($seasons))
                    <x-select name="season_id" required>
                        <option value="">انتخاب فصل *</option>
                        @foreach($seasons as $season)
                            <option value="{{$season->id}}"
                                    @if($season->id ==$lesson->season_id) selected @endif >
                                {{$season->title}}
                            </option>
                        @endforeach

                    </x-select>
                @endif
                <div class="w-100">
                    <p class="box__title mt-2">ایا این درس رایگان است ؟ *</p>
                    <div class="w-100 ">
                        <div class="notificationGroup">
                            <input id="lesson-upload-field-1" name="is_free" value="0" type="radio"
                                   @if(!$lesson->is_free) checked @endif >
                            <label for="lesson-upload-field-1">خیر</label>
                        </div>
                        <div class="notificationGroup">
                            <input id="lesson-upload-field-2" name="is_free" value="1" type="radio"
                                   @if($lesson->is_free) checked @endif
                            >
                            <label for="lesson-upload-field-2">بله</label>
                        </div>
                    </div>
                </div>

                <x-file name="lesson_file" placeholder="آپلود درس *" :value="$lesson->media" />

                <x-textarea name="body" placeholder="توضیحات درس" {{$lesson->body}}/>


                <br>

                <button class="btn btn-brand">بروزرسانی درس</button>
            </form>
        </div>
    </div>
@endsection




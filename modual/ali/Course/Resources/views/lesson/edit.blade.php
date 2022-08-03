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


                <div class="w-100 mlg-15">
                    <input style="width: 88%;border: 1px solid #ddd;margin-bottom: 20px;    direction: ltr;" type="text"
                           id="image_label"
                           class="text text-left" name="filePath"
                           value="{{$lesson->media->filename}}"
                           aria-label="Image" aria-describedby="button-image">
                    <div style="display: inline-block;width: 10%" class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="button-image">انتخاب درس</button>
                    </div>
                </div>

                @error('filePath')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                 </span>
                @enderror


                <x-TextArea name="body" placeholder="توضیحات درس" value="{!!$lesson->body!!}"/>


                <button style="margin-top: 30px" class="btn btn-brand">بروزرسانی درس</button>
            </form>
        </div>
    </div>
@endsection




@extends("Dashboard::master")

@section('breadcrumb')
    <li><a href="{{route('courses.index')}}" title="دوره">دوره ها</a></li>
    <li><a href="#" title=" ایجاد دوره"> ایجاد جلسه</a></li>
@endsection

@section('content')
    <div class="row no-gutters">
        <div class="col-12 bg-white">
            <p class="box__title">ایجاد جلسه</p>
            <form action="{{route('courses.store')}}"
                  class="padding-30" method="post"
                  enctype="multipart/form-data">

                @csrf


                <x-input name="title" type="text" placeholder="عنوان جلسه جدید " required/>

                <x-input type="text" name="slug" class="text-left" placeholder="  نام انگلیسی درس اختیاری" required/>

                <div class="w-100">
                    <p class="box__title mt-2">ایا این درس رایگان است ؟ </p>
                    <div class="w-100 ">
                        <div class="notificationGroup">
                            <input id="lesson-upload-field-1" name="free" value="0" type="radio" checked="">
                            <label for="lesson-upload-field-1">خیر</label>
                        </div>
                        <div class="notificationGroup">
                            <input id="lesson-upload-field-2"  name="free" value="1"  type="radio">
                            <label for="lesson-upload-field-2">بله</label>
                        </div>
                    </div>
                </div>
                <x-select name="season_id" required>
                    <option value="">انتخاب فصل</option>
                    @foreach($seasons as $season)
                        <option value="{{$season->id}}"
                                @if($season->id ==old('teacher_id') ) selected @endif >
                            {{$season->title}}
                        </option>
                    @endforeach

                </x-select>


                <x-file name="lesson_file" placeholder="آپلود درس" required/>


                <x-textarea name="body" placeholder="توضیحات درس"/>


                <br>

                <button class="btn btn-brand">ایجاد درس</button>
            </form>
        </div>
    </div>
@endsection


@section('js')
    <script src="/panel/js/tagsInput.js"></script>
@endsection

@extends("Dashboard::master")

@section('breadcrumb')
    <li><a href="{{route('courses.index')}}" title="دوره">دوره</a></li>
    <li><a href="#" title=" ایجاد دوره"> ایجاد دوره</a></li>
@endsection

@section('content')
    <div class="row no-gutters  ">
        <div class="col-12 bg-white">
            <p class="box__title">ایجاد دوره</p>
            <form action="{{route('courses.store')}}" class="padding-30" method="post" enctype="multipart/form-data">

                @csrf


                <x-input name="title" type="text" placeholder="عنوان دوره " required/>

                <x-input type="text" name="slug" class="text-left" placeholder="نام انگلیسی دوره" required/>


                <div class="d-flex multi-text">
                    <x-input type="text" name="priority" class="text-left mlg-15" placeholder="ردیف دوره"/>
                    <x-input type="text" name="price" placeholder="مبلغ دوره" class="text-left  " required/>
                    <x-input type="number" name="percent" placeholder="درصد مدرس" class="text-left " required/>
                </div>


                <x-select name="teacher_id" required>
                    <option value="">انتخاب مدرس دوره</option>
                    @foreach($teachers as $row)
                        <option value="{{$row->id}}"
                                @if($row->id ==old('teacher_id') ) selected @endif >
                            {{$row->name}}
                        </option>
                    @endforeach

                </x-select>

                <x-tag-select name="tags"/>

                <x-select name="type" required>
                    <option value="">نوع دوره</option>
                    @foreach(\ali\Course\Models\Course::$types as $row)
                        <option
                            value="{{$row}}"
                            @if($row==old('type') ) selected @endif >

                            @lang($row)
                        </option>
                    @endforeach
                </x-select>

                <x-select name="status" required>
                    <option value="">وضعیت دوره</option>
                    @foreach(\ali\Course\Models\Course::$statuses as $row)
                        <option value="{{$row}}"
                                @if($row==old('status') ) selected @endif >
                            @lang($row)
                        </option>
                    @endforeach
                </x-select>
                <x-select name="category_id" required>
                    <option value="">دسته بندی</option>
                    @foreach($categories as $row)
                        <option value="{{$row->id}}"
                                @if($row->id==old('category_id') ) selected @endif >
                            {{$row->title}}</option>
                    @endforeach

                </x-select>


                <x-file name="image" placeholder="آپلود بنر دوره" required/>


                <x-textarea name="body" placeholder="توضیحات دوره"/>


                <br>

                <button class="btn btn-brand">ایجاد دوره</button>
            </form>
        </div>
    </div>
@endsection


@section('js')
    <script src="/panel/js/tagsInput.js"></script>
@endsection

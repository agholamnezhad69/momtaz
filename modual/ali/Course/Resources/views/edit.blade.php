@extends("Dashboard::master")

@section('breadcrumb')
    <li><a href="{{route('courses.index')}}" title="دوره">دوره</a></li>
    <li><a href="{{route('courses.index')}}" title="دوره">دوره</a></li>
    <li><a href="#" title=" ایجاد دوره"> ویرایش دوره</a></li>
@endsection

@section('content')
    <div class="row no-gutters  ">
        <div class="col-12 bg-white">
            <p class="box__title">ایجاد دوره</p>
            <form action="{{route('courses.update',$course->id)}}" class="padding-30" method="post"
                  enctype="multipart/form-data">

                @csrf
                @method('patch')


                <x-input name="title"
                         type="text"
                         placeholder="عنوان دوره "
                         required
                         value="{{$course->title}}"
                />

                <x-input type="text" name="slug" class="text-left" placeholder="نام انگلیسی دوره" required
                         value="{{$course->slug}}"/>


                <div class="d-flex multi-text">
                    <x-input type="text" name="priority" class="text-left mlg-15" placeholder="ردیف دوره"
                             value="{{$course->priority}}"/>
                    <x-input type="text" name="price" placeholder="مبلغ دوره" class="text-left  "
                             value="{{$course->price}}" required/>
                    <x-input type="number" name="percent" placeholder="درصد مدرس" class="text-left " required
                             value="{{$course->percent}}"/>
                </div>


{{--                <x-select name="teacher_id" required>--}}
{{--                    <option value="">انتخاب مدرس دوره</option>--}}
{{--                    @foreach($teachers as $row)--}}
{{--                        <option value="{{$row->id}}"--}}
{{--                                @if($row->id ==$course->teacher_id)  selected @endif >--}}
{{--                            {{$row->name}}--}}
{{--                        </option>--}}
{{--                    @endforeach--}}

{{--                </x-select>--}}

                <x-select name="teacher_id" required>
                    <option value="">انتخاب مدرس دوره</option>
                    @can([\ali\RolePermissions\Models\Permission::PERMISSION_SUPER_ADMIN,\ali\RolePermissions\Models\Permission::PERMISSION_MANAGE_COURSES])
                        @foreach($teachers as $row)
                            <option value="{{$row->id}}"
                                    @if($row->id ==$course->teacher_id)  selected @endif >
                                {{$row->name}}
                            </option>
                        @endforeach
                    @else
                        <option value="{{auth()->id()}}">{{auth()->user()->name}}</option>
                    @endcan

                </x-select>



                <x-tag-select name="tags"/>

                <x-select name="type" required>
                    <option value="">نوع دوره</option>
                    @foreach(\ali\Course\Models\Course::$types as $row)
                        <option
                            value="{{$row}}"
                            @if($row==$course->type ) selected @endif >

                            @lang($row)
                        </option>
                    @endforeach
                </x-select>

                <x-select name="status" required>
                    <option value="">وضعیت دوره</option>
                    @foreach(\ali\Course\Models\Course::$statuses as $row)
                        <option value="{{$row}}"
                                @if($row==$course->statues ) selected @endif >
                            @lang($row)
                        </option>
                    @endforeach
                </x-select>
                <x-select name="category_id" required>
                    <option value="">دسته بندی</option>
                    @foreach($categories as $row)
                        <option value="{{$row->id}}"
                                @if($row->id==$course->category_id)  selected @endif >
                            {{$row->title}}</option>
                    @endforeach

                </x-select>


                <x-file name="image" placeholder="آپلود بنر دوره" :value="$course->banner" />


                <x-textarea name="body" placeholder="توضیحات دوره" value="{{$course->body}}"/>


                <br>

                <button class="btn btn-brand">بروز رسانی</button>
            </form>
        </div>
    </div>
@endsection


@section('js')
    <script src="/panel/js/tagsInput.js"></script>
@endsection

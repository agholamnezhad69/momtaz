@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{route('discounts.index')}}" class="is-active">تخفیف ها</a></li>
    <li><a href="{{route('discounts.edit',$discount->id)}}" class="is-active"> ویرایش کد تخفیف ها </a></li>
@endsection

@section('content')

    <div class="main-content padding-0 discounts">
        <div class="row no-gutters  ">
            <div class="col-4 bg-white">
                <p class="box__title">ویرایش کد تخفیف </p>
                <form action="{{route('discounts.update',$discount->id)}}" method="post" class="padding-10"
                      id="discount-form">

                    @csrf
                    @method('patch')
                    <x-input type="text" placeholder="کد تخفیف" name="code"
                             value="{{$discount->code}}"/>
                    <x-input type="number" placeholder="درصد تخفیف" name="percent"
                             value="{{$discount->percent}}"/>
                    <x-input type="number" placeholder="محدودیت افراد" name="usage_limitation"
                             value="{{$discount->usage_limitation}}"/>
                    <x-input type="text" id="expire_at" placeholder="محدودیت زمانی به ساعت" name="expire_at"
                             value=" {{$discount->expire_at ? createJalaliFromCarbon($discount->expire_at) : null}}"
                    />

                    <p class="box__title">این تخفیف برای</p>
                    <div class="notificationGroup">
                        <input id="discounts-field-1" class="discounts-field-pn" name="type"
                               value="{{\ali\Discount\Models\Discount::TYPE_ALL}}" type="radio"
                            {{$discount->type == \ali\Discount\Models\Discount::TYPE_ALL ? "checked" :""}} />

                        <label for="discounts-field-1">همه دوره ها</label>
                    </div>
                    <div class="notificationGroup">
                        <input id="discounts-field-2" class="discounts-field-pn" name="type"
                               value="{{\ali\Discount\Models\Discount::TYPE_SPECIAL}}"
                               type="radio"
                            {{$discount->type == \ali\Discount\Models\Discount::TYPE_SPECIAL ? "checked" :""}}
                        />
                        <label for="discounts-field-2">دوره خاص</label>
                    </div>
                    @error('type')
                    <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                      </span>
                    @enderror



                    <div id="selectCourseContainer"
                         class="{{$discount->type == \ali\Discount\Models\Discount::TYPE_ALL ? "d-none" : ""}}">
                        <select name="courses[]" class="my_course_selection" multiple="multiple">
                            @foreach($courses as $course)
                                <option
                                    value="{{$course->id}}" {{$discount->courses->contains($course->id) ? "selected" :""}}>
                                    {{$course->title}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @error('courses')
                    <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                      </span>
                    @enderror


                    <x-input type="text" name="link" placeholder="لینک اطلاعات بیشتر" value="{{$discount->link}}"/>

                    <x-input type="text" name="description" placeholder="توضیحات" class="margin-bottom-15"
                             value="{{$discount->description}}"/>

                    <button class="btn btn-success">بروزرسانی</button>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('bootstrap_css')
    <link rel="stylesheet" href="/assets/persianDataPicker/css/bootstrap.min.css">
@endsection
@section('css')
    <link rel="stylesheet" href="/assets/persianDataPicker/css/jquery.md.bootstrap.datetimepicker.style.css"/>
    <link href="/assets/multiSelect/css/select2.min.css" rel="stylesheet"/>
@endsection
@section('js')

    <script src="/assets/persianDataPicker/js/bootstrap.bundle.min.js"></script>

    <script src="/assets/persianDataPicker/js/jquery.md.bootstrap.datetimepicker.js"></script>

    <script src="/assets/multiSelect/js/select2.min.js"></script>

    <script type="text/javascript">
        $('#expire_at').MdPersianDateTimePicker({
            targetTextSelector: '#expire_at',
            // fromDate: true,
            // groupId: '#expire_time',
            //  modalMode: true,
            enableTimePicker: true,
            // rangeSelector: true,

        });

        $('.my_course_selection').select2({
            placeholder: "یک یا چند دوره را انتخاب کنید"
        });
    </script>




@endsection

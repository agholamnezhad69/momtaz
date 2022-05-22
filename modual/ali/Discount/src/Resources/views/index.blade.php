@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{route('discounts.index')}}" class="is-active">تخفیف ها</a></li>
@endsection

@section('content')
    <div class="main-content padding-0 discounts">
        <div class="row no-gutters  ">
            <div class="col-8 margin-left-10 margin-bottom-15 border-radius-3">
                <p class="box__title">دسته بندی ها</p>
                <div class="table__box">
                    <div class="table-box">
                        <table class="table">
                            <thead role="rowgroup">
                            <tr role="row" class="title-row">
                                <th>کد تخفیف</th>
                                <th>درصد</th>
                                <th>محدودیت زمانی</th>
                                <th>توضیحات</th>
                                <th>استفاده شده</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($discounts as $discount)
                                <tr role="row" class="">
                                    <td><a href="">{{$discount->code ?? "-"}}</a></td>
                                    <td>
                                        <a href="">{{$discount->percent}}
                                            % برای
                                            <sapn
                                                class="{{$discount->type == \ali\Discount\Models\Discount::TYPE_ALL ? 'text-success' :'text-error'}}">
                                                @lang($discount->type)
                                            </sapn>
                                        </a>
                                    </td>
                                    <td>{{ $discount->expire_at ?createJalaliFromCarbon($discount->expire_at) :"بدون تاریخ انقضا"}}</td>
                                    <td>{{$discount->description}}</td>
                                    <td>{{$discount->uses}} نفر</td>
                                    <td>
                                        <a
                                            href=""
                                            onclick="deleteItem(event,'{{route('discounts.destroy',$discount->id)}}')"
                                            class="item-delete mlg-15"
                                            title="حذف">
                                        </a>
                                        <a href="{{route('discounts.edit',$discount->id)}}" class="item-edit mlg-15"
                                           title="ویرایش"></a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="col-4 bg-white">

                <p class="box__title">ایجاد تخفیف جدید</p>
                <form action="{{route('discounts.store')}}" method="post" class="padding-10" id="discount-form">

                    @csrf
                    <x-input type="text" placeholder="کد تخفیف" name="code"/>
                    <x-input type="number" placeholder="درصد تخفیف" name="percent"/>
                    <x-input type="number" placeholder="محدودیت افراد" name="usage_limitation"/>
                    <x-input type="text" id="expire_at" placeholder="محدودیت زمانی به ساعت" name="expire_at"/>

                    <p class="box__title">این تخفیف برای</p>
                    <div class="notificationGroup">
                        <input id="discounts-field-1" class="discounts-field-pn" name="type"
                               value="{{\ali\Discount\Models\Discount::TYPE_ALL}}" type="radio"/>
                        <label for="discounts-field-1">همه دوره ها</label>
                    </div>
                    <div class="notificationGroup">
                        <input id="discounts-field-2" class="discounts-field-pn" name="type"
                               value="{{\ali\Discount\Models\Discount::TYPE_SPECIAL}}"
                               type="radio"/>
                        <label for="discounts-field-2">دوره خاص</label>
                    </div>


                    <div id="selectCourseContainer" class="d-none">
                        <select name="courses[]" class="my_course_selection" multiple="multiple">
                            @foreach($courses as $course)
                                <option value="{{$course->id}}">{{$course->title}}</option>
                            @endforeach
                        </select>
                    </div>

                    @error('courses')
                    <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                      </span>
                    @enderror

                    <x-input type="text" name="link" placeholder="لینک اطلاعات بیشتر"/>

                    <x-input type="text" name="description" placeholder="توضیحات" class="margin-bottom-15"/>

                    <button class="btn btn-success">اضافه کردن</button>
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

    <script src="/assets/persianDataPicker/js/jquery.md.bootstrap.datetimepicker.js">


    </script>
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

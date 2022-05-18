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
                                <th>شناسه</th>
                                <th>درصد</th>
                                <th>محدودیت زمانی</th>
                                <th>توضیحات</th>
                                <th>استفاده شده</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr role="row" class="">
                                <td><a href="">1</a></td>
                                <td><a href="">50%</a></td>
                                <td>2 ساعت دیگر</td>
                                <td>مناسبت عید نوروز</td>
                                <td>0 نفر</td>
                                <td>
                                    <a href="" class="item-delete mlg-15"></a>
                                    <a href="edit-discount.html" class="item-edit " title="ویرایش"></a>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-4 bg-white">
                <p class="box__title">ایجاد تخفیف جدید</p>
                <form action="" method="post" class="padding-30">
                    <input type="number" placeholder="درسد تخفیف" class="text">
                    <input type="number" placeholder="محدودیت افراد" class="text">
                    <input type="text" id="expire_time" placeholder="محدودیت زمانی به ساعت" class="text">

                    <p class="box__title">این تخفیف برای</p>
                    <div class="notificationGroup">
                        <input id="discounts-field-1" class="discounts-field-pn" name="discounts-field" type="radio"/>
                        <label for="discounts-field-1">همه دوره ها</label>
                    </div>
                    <div class="notificationGroup">
                        <input id="discounts-field-2" class="discounts-field-pn" name="discounts-field" type="radio"/>
                        <label for="discounts-field-2">دوره خاص</label>
                    </div>
                    <select name="">
                        @foreach($courses as $course)
                            <option value="{{$course->id}}">{{$course->title}}</option>
                        @endforeach
                    </select>
                    <input type="text" placeholder="لینک اطلاعات بیشتر" class="text">
                    <input type="text" placeholder="توضیحات" class="text margin-bottom-15">

                    <button class="btn btn-brand">اضافه کردن</button>
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
@endsection
@section('js')

    <script src="/assets/persianDataPicker/js/bootstrap.bundle.min.js"></script>

    <script src="/assets/persianDataPicker/js/jquery.md.bootstrap.datetimepicker.js"></script>

    <script type="text/javascript">
        $('#expire_time').MdPersianDateTimePicker({
            targetTextSelector: '#expire_time',
            // fromDate: true,
            // groupId: '#expire_time',
            //  modalMode: true,
            enableTimePicker: true,
            // rangeSelector: true,

        });
    </script>
@endsection

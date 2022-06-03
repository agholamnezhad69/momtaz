@extends('Dashboard::master')

@section('breadcrumb')


    <li><a href="{{route('settlements.index')}}" class="is-active"> تسویه حساب ها</a></li>


@endsection



@section('content')

    <div class="main-content">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item {{request()->status == ""? "is-active":""}}" href="{{route('settlements.index')}}">
                    همه تسویه ها</a>

                <a class="tab__item {{request()->status == \ali\Payment\Models\Settlement::STATUS_SETTLED? "is-active":""}} "
                   href="?{{ request()->getQueryString() }}&status={{\ali\Payment\Models\Settlement::STATUS_SETTLED}}">تسویه های واریز شده</a>

                <a class="tab__item {{request()->status == \ali\Payment\Models\Settlement::STATUS_PENDING? "is-active":""}} "
                   href="?{{ request()->getQueryString() }}&status={{\ali\Payment\Models\Settlement::STATUS_PENDING}}">تسویه های در حال بررسی</a>

                <a class="tab__item {{request()->status == \ali\Payment\Models\Settlement::STATUS_REJECTED? "is-active":""}}"
                   href="?{{ request()->getQueryString() }}&status={{\ali\Payment\Models\Settlement::STATUS_REJECTED}}">تسویه های رد شده</a>

                <a class="tab__item {{request()->status == \ali\Payment\Models\Settlement::STATUS_CANCELED? "is-active":""}}"
                   href="?{{ request()->getQueryString() }}&status={{\ali\Payment\Models\Settlement::STATUS_CANCELED}}">تسویه های لغو شده</a>

                <a class="tab__item " href="{{route('settlements.create')}}">درخواست تسویه جدید</a>
            </div>
        </div>
        <div class="bg-white padding-20">
            <div class="t-header-search">
                <form action="{{route("settlements.index")}}">
                    <div class="t-header-searchbox font-size-13">
                        <div type="text" class="text search-input__box ">جستجوی تسویه حساب</div>
                        <div class="t-header-search-content ">
                            <input type="text" name="toCart" value="{{request()->toCart}}" class="text"
                                   placeholder="شماره کارت مقصد">
                            <input type="text" name="fromCart" value="{{request()->fromCart}}" class="text"
                                   placeholder="شماره کارت مبدا">
                            <input type="text" name="date" value="{{request()->date}}" class="text" placeholder="تاریخ"
                                   id="date">
                            <input type="text" name="email" value="{{request()->email}}" class="text"
                                   placeholder="ایمیل">
                            <input type="text" name="name" value="{{request()->name}}" class="text margin-bottom-20"
                                   placeholder="نام و نام خانوادگی">
                            <input type="submit" class="btn btn-success" value="جستجو">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table__box">
            <table class="table">
                <thead role="rowgroup">
                <tr role="row" class="title-row">
                    <th>شناسه تسویه</th>
                    <th>کاربر</th>
                    <th> ایمیل کاربر</th>
                    <th>نام مبدا</th>
                    <th>شماره کارت مبدا</th>
                    <th>نام مقصد</th>
                    <th>شماره کارت مقصد</th>
                    <th>تاریخ درخواست واریز</th>
                    <th>تاریخ واریز شده</th>
                    <th>مبلغ (تومان )</th>
                    <th>وضعیت</th>
                    @can(\ali\RolePermissions\Models\Permission::PERMISSION_MANAGE_SETTLEMENT)
                        <th>عملیات</th>
                    @endcan
                </tr>
                </thead>
                <tbody>

                @foreach($settlements as $settlement)
                    <tr role="row">
                        <td><a href="">{{$settlement->transaction_id ?? '-'}}</a></td>
                        <td><a href="{{route("users.info",$settlement->user->id)}}">{{$settlement->user->name}}</a></td>
                        <td><a href="">{{$settlement->user->email}}</a></td>
                        <td><a href="">{{$settlement->from ?$settlement->from['name'] :'-'}}</a></td>
                        <td><a href="">{{$settlement->from ?$settlement->from['cart'] :'-'}}</a></td>
                        <td><a href="">{{$settlement->to ?$settlement->to['name'] :'-'}}</a></td>
                        <td><a href="">{{$settlement->to ?$settlement->to['cart'] :'-'}}</a></td>
                        <td><a href="">{{$settlement->created_at->diffForHumans()}}</a></td>
                        <td><a href="">{{$settlement->settled_at ? $settlement->settled_at :'-'}}</a></td>
                        <td><a href="">{{$settlement->amount}}</a></td>
                        <td><a href="" class="{{$settlement->getStatusCssClass()}}">@lang($settlement->status)</a></td>

                        @can(\ali\RolePermissions\Models\Permission::PERMISSION_MANAGE_SETTLEMENT)
                            <td>
                                <a href="{{route("settlements.edit",$settlement->id)}}"
                                   class="item-edit"
                                   title="ویرایش"></a>
                            </td>
                        @endcan
                    </tr>

                @endforeach


                </tbody>
            </table>
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
        $('#date').MdPersianDateTimePicker({
            targetTextSelector: '#date',
        });

    </script>

@endsection

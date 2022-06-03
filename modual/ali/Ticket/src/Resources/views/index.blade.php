@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{route('tickets.index')}}" title="تیکت ها">تیکت ها</a></li>
@endsection


@section('content')

    <div class="main-content tickets">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item {{request()->status == ""? "is-active":""}}" href="{{route("tickets.index")}}">همه تیکت ها</a>
                @can(\ali\RolePermissions\Models\Permission::PERMISSION_MANAGE_TICKETS)
                    <a class="tab__item {{request()->status == "open"? "is-active":""}} " href="?{{ request()->getQueryString() }}&status=open">جدید ها (خوانده نشده)</a>
                    <a class="tab__item {{request()->status == "replied"? "is-active":""}} " href="?{{ request()->getQueryString() }}&status=replied">پاسخ داده شده ها</a>
                    <a class="tab__item {{request()->status == "close"? "is-active":""}} " href="?{{ request()->getQueryString() }}&status=close">بسته شده</a>
                @endcan

                <a class="tab__item " href="{{route("tickets.create")}}">ارسال تیکت جدید</a>
            </div>
        </div>
        @can(\ali\RolePermissions\Models\Permission::PERMISSION_MANAGE_TICKETS)
            <div class="bg-white padding-20">
                <div class="t-header-search">
                    <form action="{{route("tickets.index")}}">
                        <div class="t-header-searchbox font-size-13">
                            <input type="text" class="text search-input__box font-size-13" name="title"
                                   value="{{request()->title}}"
                                   placeholder="جستجوی در تیکت ها">
                            <div class="t-header-search-content ">
                                <input type="text" class="text" name="email" placeholder="ایمیل"
                                       value="{{request()->email}}">
                                <input type="text" class="text" name="name" placeholder="نام و نام خانوادگی"
                                       value="{{request()->name}}">
                                <input type="text" class="text margin-bottom-20" name="date" id="date"
                                       placeholder="تاریخ" value="{{request()->date}}">
                                <button type="submit" class="btn btn-success">جستجو</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endcan

        <div class="table__box">
            <table class="table">
                <thead role="rowgroup">
                <tr role="row" class="title-row">
                    <th>شناسه</th>
                    <th>عنوان تیکت</th>
                    <th>نام ارسال کننده</th>
                    <th>ایمیل ارسال کننده</th>
                    <th>آخرین بروزرسانی</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>

                @foreach($tickets as $ticket)
                    <tr role="row">
                        <td><a href="">{{$ticket->id}}</a></td>
                        <td><a href="{{route('tickets.show',$ticket->id)}}">{{$ticket->title}}</a></td>
                        <td>{{$ticket->user->name}}</td>
                        <td>{{$ticket->user->email}}</td>
                        <td>{{createJalaliFromCarbon($ticket->created_at)}}</td>
                        <td class="text-info">@lang($ticket->status)</td>
                        <td>
                            <a href="{{route("tickets.close",$ticket->id)}}">بستن تیکت</a>

                            @can(\ali\RolePermissions\Models\Permission::PERMISSION_MANAGE_TICKETS)
                                <a href="" onclick="deleteItem(event, '{{ route('tickets.destroy', $ticket->id) }}')"
                                   class="item-delete mlg-15" title="حذف"></a>
                            @endcan

                        </td>
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











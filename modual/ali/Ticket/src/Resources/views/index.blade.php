@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{route('tickets.index')}}" title="تیکت ها">تیکت ها</a></li>
@endsection


@section('content')
    <div class="main-content tickets">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item is-active" href="tickets.html">همه تیکت ها</a>
                <a class="tab__item " href="tickets.html">جدید ها (خوانده نشده)</a>
                <a class="tab__item " href="tickets.html">پاسخ داده شده ها</a>
                <a class="tab__item " href="{{route("tickets.create")}}">ارسال تیکت جدید</a>
            </div>
        </div>
        <div class="bg-white padding-20">
            <div class="t-header-search">
                <form action="" onclick="event.preventDefault();">
                    <div class="t-header-searchbox font-size-13">
                        <div type="text" class="text search-input__box ">جستجوی دوره</div>
                        <div class="t-header-search-content " style="display: none;">
                            <input type="text" class="text" placeholder="ایمیل">
                            <input type="text" class="text " placeholder="نام و نام خانوادگی">
                            <input type="text" class="text margin-bottom-20" placeholder="تاریخ">
                            <btutton class="btn btn-brand">جستجو</btutton>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table__box">
            <table class="table">
                <thead role="rowgroup">
                <tr role="row" class="title-row">
                    <th>شناسه</th>
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
                        <td><a href="">{{$ticket->user->name}}</a></td>
                        <td><a href="">{{$ticket->user->email}}</a></td>
                        <td>{{$ticket->user->created_at}}</td>
                        <td class="text-info">جدید</td>
                        <td>
                            <a href="#">بستن تیکت</a>
                            <a href="" onclick="deleteItem(event, '{{ route('tickets.destroy', $ticket->id) }}')"
                               class="item-delete mlg-15" title="حذف"></a>

                        </td>
                    </tr>
                @endforeach
                <!--                <tr role="row">
                    <td><a href="">1</a></td>
                    <td><a href="">محمد نیکو</a></td>
                    <td><a href="">mmd@gmail.com</a></td>
                    <td>1399/05/01</td>
                    <td class="text-success">پاسخ داده شده</td>
                    <td>
                        <a href="" class="item-delete mlg-15" title="حذف"></a>
                        <a href="show-comment.html" target="_blank" class="item-eye mlg-15" title="مشاهده"></a>
                        <a href="edit-comment.html" class="item-edit " title="ویرایش"></a>
                    </td>
                </tr>
                <tr role="row" class="close-status">
                    <td><a href="">1</a></td>
                    <td><a href="">محمد نیکو</a></td>
                    <td><a href="">mmd@gmail.com</a></td>
                    <td>1399/05/01</td>
                    <td>بسته شده</td>
                    <td>
                        <a href="" class="item-delete mlg-15" title="حذف"></a>
                        <a href="show-comment.html" target="_blank" class="item-eye mlg-15" title="مشاهده"></a>
                        <a href="edit-comment.html" class="item-edit " title="ویرایش"></a>
                    </td>
                </tr>-->
                </tbody>
            </table>
        </div>
    </div>
@endsection











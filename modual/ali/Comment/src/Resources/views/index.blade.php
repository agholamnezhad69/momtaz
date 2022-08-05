@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{route('tickets.index')}}" title="نظرات">نظرات</a></li>
@endsection


@section('content')

    <div class="main-content">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item is-active" href="comments.html"> همه نظرات</a>
                <a class="tab__item " href="comments.html">نظرات تاییده نشده</a>
                <a class="tab__item " href="comments.html">نظرات تاییده شده</a>
            </div>
        </div>
        <div class="bg-white padding-20">
            <div class="t-header-search">
                <form action="" onclick="event.preventDefault();">
                    <div class="t-header-searchbox font-size-13">
                        <input type="text" class="text search-input__box font-size-13" placeholder="جستجوی در نظرات">
                        <div class="t-header-search-content " style="display: none;">
                            <input type="text" class="text" placeholder="قسمتی از متن">
                            <input type="text" class="text" placeholder="ایمیل">
                            <input type="text" class="text margin-bottom-20" placeholder="نام و نام خانوادگی">
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
                    <th>ارسال کننده</th>
                    <th>برای</th>
                    <th>دیدگاه</th>
                    <th>تاریخ</th>
                    <th>تعداد پاسخ ها</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                <tr role="row">
                    <td><a href="">1</a></td>
                    <td><a href="">محمد نیکو</a></td>
                    <td><a href="">دوره لاراول</a></td>
                    <td>دوره خوبی بود</td>
                    <td>1399/05/01</td>
                    <td>13</td>
                    <td class="text-success">تاییده شده</td>
                    <td>
                        <a href="" class="item-delete mlg-15" title="حذف"></a>
                        <a href="show-comment.html" class="item-reject mlg-15" title="رد"></a>
                        <a href="show-comment.html" target="_blank" class="item-eye mlg-15" title="مشاهده"></a>
                        <a href="show-comment.html" class="item-confirm mlg-15" title="تایید"></a>
                        <a href="edit-comment.html" class="item-edit " title="ویرایش"></a>
                    </td>
                </tr>
                <tr role="row">
                    <td><a href="">1</a></td>
                    <td><a href="">محمد نیکو</a></td>
                    <td><a href="">دوره لاراول</a></td>
                    <td>دوره خوبی بود</td>
                    <td>1399/05/01</td>
                    <td>13</td>
                    <td class="text-error">تاییده نشده</td>
                    <td>
                        <a href="" class="item-delete mlg-15" title="حذف"></a>
                        <a href="show-comment.html" class="item-reject mlg-15" title="رد"></a>
                        <a href="show-comment.html" target="_blank" class="item-eye mlg-15" title="مشاهده"></a>
                        <a href="show-comment.html" class="item-confirm mlg-15" title="تایید"></a>
                        <a href="edit-comment.html" class="item-edit " title="ویرایش"></a>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>

@endsection



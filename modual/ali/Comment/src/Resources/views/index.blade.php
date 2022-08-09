@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{route('comments.index')}}" title="نظرات">نظرات</a></li>
@endsection


@section('content')

    <div class="main-content">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item {{request("status") == "" ? 'is-active' :"" }}"
                   href="?{{ request()->getQueryString() }}&status="> همه نظرات</a>
                <a class="tab__item {{request("status") == "approved" ? "is-active" :""}}  "
                   href="?{{ request()->getQueryString() }}&status=approved">نظرات تاییده شده</a>
                <a class="tab__item {{request("status") == "new" ? "is-active" :""}}  "
                   href="?{{ request()->getQueryString() }}&status=new">نظرات تاییده نشده</a>
                <a class="tab__item {{request("status") == "rejected" ? "is-active" :""}}  "
                   href="?{{ request()->getQueryString() }}&status=rejected">نظرات رد شده</a>
            </div>
        </div>
        <div class="bg-white padding-20">
            <div class="t-header-search">
                <form action="">
                    <div class="t-header-searchbox font-size-13">
                        <input type="text" class="text search-input__box font-size-13" placeholder="جستجوی در نظرات">
                        <div class="t-header-search-content " style="display: none;">
                            <input type="text" class="text" name="body1" value="{{request()->body1}}"
                                   placeholder="قسمتی از متن">
                            <input type="text" class="text" name="email" value="{{request()->email}}"
                                   placeholder="ایمیل">
                            <input type="text" class="text margin-bottom-20" name="name" value="{{request()->name}}"
                                   placeholder="نام و نام خانوادگی">
                            <input type="submit" class="btn btn-brand" value="جستجو"/>
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
                    <th> نام ارسال کننده</th>
                    <th>ایمیل</th>
                    <th>برای</th>
                    <th>دیدگاه</th>
                    <th>تاریخ</th>
                    <th>تعداد پاسخ ها</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>

                @foreach($comments as $comment)
                    <tr role="row">
                        <td><a href="">{{$comment->id}}</a></td>
                        <td><a href="">{{isset($comment->user->name) ? $comment->user->name : "بدون نام " }}</a></td>
                        <td><a href="">{{isset($comment->user->email) ? $comment->user->email : "بدون ایمیل" }}</a></td>
                        <td><a href="">{{$comment->commentable->title}}</a></td>
                        <td>{{$comment->body}}</td>
                        <td>{{createJalaliFromCarbon($comment->created_at)}}</td>
                        <td>{{$comment->replies->count()}} ({{ $comment->not_approved_comments_count}})</td>
                        <td class="confirmation_status {{$comment->getStatusCssClass()}}">@lang($comment->status)</td>
                        <td>
                            @if(auth()->user()->hasAnyPermission(
                          \ali\RolePermissions\Models\Permission::PERMISSION_SUPER_ADMIN,
                          \ali\RolePermissions\Models\Permission::PERMISSION_MANAGE_COMMENTS
    ))
                                <a
                                    href=""
                                    onclick="deleteItem(event,'{{route('comments.destroy',$comment->id)}}')"
                                    class="item-delete mlg-15"
                                    title="حذف">
                                </a>
                                <a href=""
                                   onclick="updateConfirmationStatus(event,'{{route('comments.accept',$comment->id)}}',
                                       'آیا از تایید این مورد اطمینان دارید؟',
                                       '@lang(\ali\Comment\Models\Comment::STATUS_APPROVED)')"
                                   class="item-confirm mlg-15" title="تایید">

                                </a>
                                <a href=""
                                   onclick="updateConfirmationStatus(event,'{{route('comments.reject',$comment->id)}}',
                                       'آیا از رد شدن این مورد اطمینان دارید؟',
                                       '@lang(\ali\Comment\Models\Comment::STATUS_REJECT)')"
                                   class="item-reject mlg-15" title="رد">

                                </a>
                            @endif
                            <a href="{{route("comments.show",$comment->id)}}" class="item-eye mlg-15"
                               title="مشاهده"></a>


                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>

@endsection



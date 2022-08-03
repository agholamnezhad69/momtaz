@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{route('users.index')}}" title="کاربران">کاربران</a></li>
@endsection



@section('content')
    <div class="row no-gutters  ">
        <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
            <p class="box__title">کاربران </p>
            <div class="table__box">
                <table class="table">
                    <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>ردیف</th>
                        <th>شناسه</th>
                        <th>نام و نام خانوادگی</th>
                        <th>ایمیل</th>
                        <th>شماره موبایل</th>
                        <th>سطح کاربری</th>
                        <th>تاریخ عضویت</th>
                        <th>آی پی</th>
                        <th>وضعیت حساب</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($users as $user)
                        <tr role="row" class="">
                            <td>{{$loop->index+1}}</td>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->mobile}}</td>
                            <td>
                                <ul>
                                    @foreach($user->roles as $role)
                                        <li class="deletable-item-list">
                                            @lang($role->name)
                                            <a href=""
                                               onclick="deleteItem(
                                                   event,
                                                   '{{route('users.removeRole',
                                                    ["user"=>$user->id,"role"=>$role->name])}}'
                                                   ,'li')"
                                               class="item-delete mlg-15 d-none"
                                            ></a>
                                        </li>
                                    @endforeach


                                </ul>
                                <p><a onclick="setFormAction({{$user->id}})" href="#select-role"
                                      class="text-success"
                                      rel="modal:open">افزودن
                                        نقش کاربری</a></p>
                            </td>
                            <td>{{$user->created_at}}</td>
                            <td>{{$user->ip}}</td>
                            <td class="confirmation_status">
                                {!!$user->hasVerifiedEmail()
                                 ? '<span class="text-success">تایید شده</span>':'<span class="text-error">تایید نشده</span>'
                                !!}</td>
                            <td>
                                <a
                                    href=""
                                    onclick="deleteItem(event,'{{route('users.destroy',$user->id)}}')"
                                    class="item-delete mlg-15"
                                    title="حذف">
                                </a>
                                <a href="{{route('users.edit',$user->id)}}" class="item-edit mlg-15"
                                   title="ویرایش"></a>
                                <a href=""
                                   onclick="updateConfirmationStatus(event,'{{route("users.manualVerify",$user->id)}}',
                                       'آیا از تایید این مورد اطمینان دارید؟',
                                       'تایید شده')" class="item-confirm mlg-15" title="تایید">

                                </a>


                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                {{ $users->render('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>



    <div id="select-role" class="modal">
        <form action="{{route('users.addRole',0)}}" method="post" id="select-role-form">
            @csrf
            <select name="role">
                <option value="">یک رول را انتخاب کنید</option>
                @foreach($roles as $row)
                    <option value="{{$row->name}}">@lang($row->name)</option>
                @endforeach
            </select>
            <button class="btn btn-webamooz_net mt-2">افزودن نقش</button>
        </form>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="/panel/css/modal/jquery.modal.min.css" type="text/css"/>
@endsection
@section('js')
    <script src="/panel/js/modal/jquery.modal.min.js"></script>
    <script>


        function setFormAction(userId) {
            let form = $("#select-role-form");
            let action = '{{route('users.addRole',0)}}'

            form.attr('action', action.replace('/0/', '/' + userId + '/'))
        }

        @include("Common::layouts.feedbacks")


    </script>
@endsection






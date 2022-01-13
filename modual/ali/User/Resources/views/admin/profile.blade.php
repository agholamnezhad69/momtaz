@extends("Dashboard::master")

@section('breadcrumb')
    <li><a href="{{route('users.index')}}" title="دوره">کاربر</a></li>
    <li><a href="#" title=" ایجاد کاربر"> ویرایش پروفایل</a></li>
@endsection

@section('content')
    <div class=" row no-gutters bg-white margin-bottom-20 ">
        <div class="col-12 bg-white">
            <p class="box__title">بروزرسانی پروفایل</p>
            <x-user-photo/>
            <form action="{{route('users.profile',auth()->user()->id)}}" class="padding-30" method="post">

                @csrf

                <x-input name="name" type="text" placeholder="نام کاربر " required value="{{auth()->user()->name}}"/>
                <x-input name="email" type="email" placeholder="ایمیل " required value="{{auth()->user()->email}}"
                         class="text-left"/>
                <x-input name="mobile" type="text" placeholder="موبایل " required value="{{auth()->user()->mobile}}"/>
                <x-input name="password" type="password" placeholder="پسورد جدید " value=""/>
                <p class="rules">رمز عبور باید حداقل ۶ کاراکتر و ترکیبی از حروف بزرگ، حروف کوچک، اعداد و کاراکترهای
                    غیر الفبا مانند <strong>!@#$%^&amp;*()</strong> باشد.</p>

                @can(\ali\RolePermissions\Models\Permission::PERMISSION_TEACH)

                    <x-input name="card_number" type="text" placeholder="شماره کارت بانکی"
                             value="{{auth()->user()->card_number}}"/>

                    <x-input name="shaba" type="text" placeholder="شماره شبا بانکی"
                             value="{{auth()->user()->shaba}}"/>


                    <x-input name="username" type="text" placeholder="نام کاربری و آدرس پروفایل "
                             value="{{auth()->user()->username}}"/>

                    <p class="input-help text-left margin-bottom-12" dir="ltr">

                        <a href="{{auth()->user()->profilePath()}}">

                            {{auth()->user()->profilePath()}}

                        </a>
                    </p>
                    <x-input name="headline" type="text" placeholder="عنوان " value="{{auth()->user()->headline}}"/>
                    <x-textarea name="bio" placeholder="بیوگرافی " value="{{auth()->user()->bio}}"/>
                @endcan

                <x-input name="website" type="text" placeholder="وب سایت " value="{{auth()->user()->website}}"/>
                <x-input name="linkedin" type="text" placeholder="لینک دین " value="{{auth()->user()->linkedin}}"/>
                <x-input name="facebook" type="text" placeholder="فیس بوک " value="{{auth()->user()->facebook}}"/>
                <x-input name="youtube" type="text" placeholder="یوتویوب " value="{{auth()->user()->youtube}}"/>
                <x-input name="twitter" type="text" placeholder="توییتر " value="{{auth()->user()->twitter}}"/>
                <x-input name="instagram" type="text" placeholder="اینستاگرام" value="{{auth()->user()->instagram}}"/>
                <x-input name="telegram" type="text" placeholder="تلگرام " value="{{auth()->user()->telegram}}"/>


                <br>

                <button class="btn btn-brand">بروز رسانی</button>
            </form>
        </div>
    </div>

@endsection


@section('js')
    <script src="/panel/js/tagsInput.js"></script>
    <script>
        @include("Common::layouts.feedbacks")
    </script>
@endsection

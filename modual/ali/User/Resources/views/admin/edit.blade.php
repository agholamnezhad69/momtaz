@extends("Dashboard::master")

@section('breadcrumb')
    <li><a href="{{route('users.index')}}" title="دوره">کاربر</a></li>
    <li><a href="#" title=" ایجاد کاربر"> ویرایش کاربر</a></li>
@endsection

@section('content')
    <div class=" row no-gutters bg-white margin-bottom-20 ">
        <div class="col-12 bg-white">
            <p class="box__title">ایجاد کاربر</p>
            <form action="{{route('users.update',$user->id)}}" class="padding-30" method="post"
                  enctype="multipart/form-data">

                @csrf
                @method('patch')


                <x-input name="name" type="text" placeholder="نام کاربر " required value="{{$user->name}}"/>
                <x-input name="email" type="email" placeholder="ایمیل " required value="{{$user->email}}"
                         class="text-left"/>
                <x-input name="username" type="text" placeholder="نام کاربری " value="{{$user->username}}"/>
                <x-input name="headline" type="text" placeholder="عنوان " value="{{$user->headline}}"/>
                <x-input name="mobile" type="text" placeholder="موبایل " required value="{{$user->mobile}}"/>
                <x-input name="website" type="text" placeholder="وب سایت " value="{{$user->website}}"/>
                <x-input name="linkedin" type="text" placeholder="لینک دین " value="{{$user->linkedin}}"/>
                <x-input name="facebook" type="text" placeholder="فیس بوک " value="{{$user->facebook}}"/>
                <x-input name="youtube" type="text" placeholder="یوتویوب " value="{{$user->youtube}}"/>
                <x-input name="twitter" type="text" placeholder="توییتر " value="{{$user->twitter}}"/>
                <x-input name="instagram" type="text" placeholder="اینستاگرام" value="{{$user->instagram}}"/>
                <x-input name="telegram" type="text" placeholder="تلگرام " value="{{$user->telegram}}"/>


                <x-select name="status">
                    <option value="">وضعیت کاربر</option>
                    @foreach(\ali\User\Models\User::$statuses as $status)
                        <option value="{{$status}}"
                                @if($status==$user->status ) selected @endif >
                            @lang($status)
                        </option>
                    @endforeach
                </x-select>


                <x-file name="image" placeholder="آپلود بنر کاربر" :value="$user->image"/>
                <x-input name="password" type="password" placeholder="پسورد جدید " value=""/>
                <x-textarea name="bio" placeholder="بیوگرافی " value="{{$user->bio}}"/>


                <br>

                <button class="btn btn-brand">بروز رسانی</button>
            </form>
        </div>
    </div>
    <div class="row no-gutters margin-bottom-20">
        <div class="col-6 margin-left-10 margin-bottom-20">
            <p class="box__title">درحال یادگیری</p>
            <div class="table__box">
                <table class="table">
                    <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>شناسه</th>
                        <th>نام دوره</th>
                        <th>نام مدرس</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr role="row" class="">
                        <td><a href="">1</a></td>
                        <td><a href="">دوره اچ تی ام ال</a></td>
                        <td><a href="">ابوفضل</a></td>
                    </tr>
                    <tr role="row" class="">
                        <td><a href="">1</a></td>
                        <td><a href="">دوره اچ تی ام ال</a></td>
                        <td><a href="">ابوفضل</a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-6 margin-bottom-20">
            <p class="box__title">دوره های مدرس</p>
            <div class="table__box">
                <table class="table">
                    <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>شناسه</th>
                        <th>نام دوره</th>
                        <th>نام مدرس</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($user->courses as $course)
                        <tr role="row" class="">
                            <td><a href="">{{$course->id}}</a></td>
                            <td><a href="">{{$course->title}}</a></td>
                            <td><a href="">{{$course->teacher->name}}</a></td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script src="/panel/js/tagsInput.js"></script>
    <script>
        @include("Common::layouts.feedbacks")
    </script>
@endsection

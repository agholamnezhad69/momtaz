@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{route('courses.index')}}" title="دوره">دوره</a></li>
@endsection



@section('content')
    <div class="row no-gutters  ">
        <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
            <p class="box__title">دوره ها</p>
            <div class="table__box">
                <table class="table">
                    <thead role="rowgroup">
                    <tr role="row" class="title-row">


                        <th>ردیف</th>
                        <th>آی دی</th>
                        <th>بنبر</th>
                        <th>عنوان</th>
                        <th>مدرس</th>
                        <th>قیمت</th>
                        <th>جزئیات</th>
                        <th>نوع</th>
                        <th>درصد مدرس</th>
                        <th>وضعیت</th>
                        <th>وضعیت تایید</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($courses as $row)
                        <tr role="row" class="">
                            <td><a href="">{{$row->priority}}</a></td>
                            <td><a href="">{{$row->id}}</a></td>
                            <td><img width="80" src="{{$row->banner->thumb}}" alt=""></td>
                            <td><a href="">{{$row->title}}</a></td>
                            <td><a href="">{{$row->teacher->name}}</a></td>
                            <td><a href="">{{$row->price}}</a></td>
                            <td><a href="{{route('courses.details',$row->id)}}">مشاهده</a></td>
                            <td>@lang($row->type)</td>
                            <td>@lang($row->percent)</td>
                            <td class="status">@lang($row->statues)</td>
                            <td class="confirmation_status">@lang($row->confirmation_status)</td>
                            <td>
                                <a
                                    href=""
                                    onclick="deleteItem(event,'{{route('courses.destroy',$row->id)}}')"
                                    class="item-delete mlg-15"
                                    title="حذف">
                                </a>
                                <a href="" target="_blank" class="item-eye mlg-15" title="مشاهده"></a>
                                <a href="{{route('courses.edit',$row->id)}}" class="item-edit mlg-15"
                                   title="ویرایش"></a>
                                <a href=""
                                   onclick="updateConfirmationStatus(event,'{{route('courses.accept',$row->id)}}',
                                       'آیا از تایید این مورد اطمینان دارید؟',
                                       '@lang(\ali\Course\Models\Course::CONFIRMATION_STATUS_ACCEPTED)')"
                                   class="item-confirm mlg-15" title="تایید">

                                </a>
                                <a href=""
                                   onclick="updateConfirmationStatus(event,'{{route('courses.reject',$row->id)}}',
                                       'آیا از رد شدن این مورد اطمینان دارید؟',
                                       '@lang(\ali\Course\Models\Course::CONFIRMATION_STATUS_REJECTED)')"
                                   class="item-reject mlg-15" title="رد">

                                </a>

                                <a href=""
                                   onclick="updateConfirmationStatus(event,'{{route('courses.lock',$row->id)}}',
                                       'آیا از قفل شدن این مورد اطمینان دارید؟',
                                       '@lang(\ali\Course\Models\Course::STATUS_LOCKED)',
                                       'status')"
                                   class="item-lock mlg-15" title="رد">

                                </a>


                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection




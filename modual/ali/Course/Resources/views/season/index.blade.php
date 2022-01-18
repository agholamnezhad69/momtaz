<div class="col-12 bg-white margin-bottom-15 border-radius-3">
    <p class="box__title">سرفصل ها</p>
    <form action="{{route('seasons.store',$course->id)}}" method="post" class="padding-30">
        @csrf
        <x-input name="title" type="text" placeholder="عنوان سرفصل" class="text"/>
        <x-input name="number" type="text" placeholder="شماره سرفصل" class="text"/>
        <button type="submit" class="btn btn-webamooz_net mt-2">اضافه کردن</button>
    </form>
    <div class="table__box padding-30">
        <table class="table">
            <thead role="rowgroup">
            <tr role="row" class="title-row">
                <th class="p-r-90">شناسه</th>
                <th>عنوان فصل</th>
                <th>وضعیت</th>
                <th>وضعیت تایید</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>

            @foreach($course->seasons as $season)
                <tr role="row" class="">
                    <td><a href="">{{$season->number}}</a></td>
                    <td><a href="">{{$season->title}}</a></td>
                    <td class="status"><a href="">
                            <span class='@if($season->status==\ali\Course\Models\Season::STATUS_OPENED)
                                text-success
                                @else
                                text-error
                                @endif'>

                                @lang($season->status)
                            </span>
                        </a>
                    </td>
                    <td class="confirmation_status"><a href="">
                            <span class='@if($season->confirmation_status==\ali\Course\Models\Season::CONFIRMATION_STATUS_ACCEPTED)
                                text-success
                                @else
                                text-error
                                @endif'>

                                @lang($season->confirmation_status)
                            </span>
                         </a>
                    </td>

                    <td class="status-">

                        <a
                            href="#"
                            onclick="deleteItem(event,'{{route('seasons.destroy',$season->id)}}')"
                            class="item-delete mlg-15"
                            title="حذف">
                        </a>
                        <a href=""
                           onclick="updateConfirmationStatus(event,'{{route('seasons.accept',$season->id)}}',
                               'آیا از تایید این مورد اطمینان دارید؟',
                               '@lang(\ali\Course\Models\Season::CONFIRMATION_STATUS_ACCEPTED)')"
                           class="item-confirm mlg-15" title="تایید">

                        </a>
                        <a href=""
                           onclick="updateConfirmationStatus(event,'{{route('seasons.reject',$season->id)}}',
                               'آیا از رد شدن این مورد اطمینان دارید؟',
                               '@lang(\ali\Course\Models\Season::CONFIRMATION_STATUS_REJECTED)')"
                           class="item-reject mlg-15" title="رد">

                        </a>
                        @if($season->status==\ali\Course\Models\Season::STATUS_OPENED)
                            <a href=""
                               onclick="updateConfirmationStatus(event,'{{route('seasons.lock',$season->id)}}',
                                   'آیا از تغییر این مورد اطمینان دارید؟',
                                   '@lang(\ali\Course\Models\Season::STATUS_LOCKED)',
                                   'status'
                                   )"
                               class="item-lock text-error mlg-15" title="تغییر">

                            </a>
                        @else
                            <a href=""
                               onclick="updateConfirmationStatus(event,'{{route('seasons.unlock',$season->id)}}',
                                   'آیا از تغییر این مورد اطمینان دارید؟',
                                   '@lang(\ali\Course\Models\Season::STATUS_OPENED)',
                                   'status'
                                   )"
                               class="item-lock text-success mlg-15" title="تغییر">

                            </a>
                        @endif


                        <a href="{{route('seasons.edit',$season->id)}}" class="item-edit " title="ویرایش"></a>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
</div>

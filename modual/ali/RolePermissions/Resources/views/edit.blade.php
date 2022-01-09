@extends("Dashboard::master")

@section('breadcrumb')
    <li><a href="{{route('role-permissions.index')}}" title="نقش های کاربری">نقش های کاربری</a></li>
    <li><a href="#" title=" ویرایش نقش های کاربری"> ویرایش نقش های کاربری</a></li>
@endsection

@section('content')
    <div class="row no-gutters  ">
        <div class="col-4 bg-white">
            <p class="box__title">بروزرسانی نقش های کاربری</p>
            <form action="{{route('role-permissions.update',$role->id)}}" method="post" class="padding-30">
                @csrf
                @method('patch')
                <input type="hidden" name="id" value="{{$role->id}}">
                <input type="text" name="name" placeholder="عنوان نقش  کاربری" class="text" value="{{$role->name}}">
                @error('name')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                  </span>
                @enderror

                <p class="box__title margin-bottom-15">انتخاب مجوزها</p>
                @foreach($permissions as $row)
                    <div class="checkbox">
                        <label class="ui-checkbox label-permission pr-3">
                            <input type="checkbox" name="permissions[{{$row->name}}]" class="sub-checkbox"
                                   data-id="1"
                                   value="{{$row->name}}"
                                   @if($role->hasPermissionTo($row->name)) checked @endif
                            >
                            <span class="checkmark"></span>
                            @lang($row->name)
                        </label>
                    </div>
                @endforeach

                @error('permissions')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror

                <br>



                <button class="btn btn-brand">بروزرسانی</button>
            </form>
        </div>
    </div>
@endsection

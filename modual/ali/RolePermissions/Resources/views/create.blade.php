<p class="box__title">ایجاد نقش کاربری</p>
<form action="{{route('role-permissions.store')}}" method="post" class="padding-30">
    @csrf
    <input type="text" name="name" placeholder="عنوان" class="text" required value="{{old('name')}}">

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
                @if(is_array(old('permissions')) && array_key_exists($row->name,old('permissions'))) checked @endif
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


    <button class="btn btn-brand">اضافه کردن</button>
</form>

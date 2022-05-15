@extends('Dashboard::master')

@section('breadcrumb')

    <li><a href="{{route('settlements.index')}}"> تسویه حساب ها</a></li>
    <li><a href="#" class="is-active"> ویرایش تسویه حساب </a></li>

@endsection


@section('content')



    <div class="main-content">
        <form action="{{route('settlements.update',$settlement->id)}}"
              class="padding-30 bg-white font-size-14"
              method="post">
            @csrf
            @method("patch")

            <x-input type="text"
                     value="{{is_array($settlement->from) && array_key_exists('name',$settlement->from) ? $settlement->from['name'] : '' }}"
                     name="from[name]"
                     placeholder="نام صاحب حساب فرستنده "/>
            <x-input type="text"
                     value="{{is_array($settlement->from) && array_key_exists('name',$settlement->from) ? $settlement->from['cart'] : ''}}"
                     name="from[cart]"
                     placeholder="شماره کارت فرستنده"/>

            <x-input type="text"
                     value="{{$settlement->to['name']}}"
                     name="to[name]"
                     placeholder="نام صاحب حساب گیرنده"/>
            <x-input type="text"
                     value="{{$settlement->to['cart']}}"
                     name="to[cart]"
                     placeholder="شماره کارت گیرنده"/>
            <x-input type="text" name="amount" value="{{$settlement->amount}}" placeholder="مبلغ به تومان"/>
            <x-select name="status">
                @foreach(\ali\Payment\Models\Settlement::$statues as $status)
                    <option value="{{$status}}"
                            @if($status==$settlement->status ) selected @endif >
                            @lang($status)
                    </option>
                @endforeach
            </x-select>

            <div class="row no-gutters border-2 margin-bottom-15 text-center ">
                <div class="w-50 padding-20 w-50">موجودی قابل برداشت :‌</div>
                <div class="bg-fafafa padding-20 w-50">{{$settlement->user->balance}}</div>
            </div>

            <button class="btn btn-brand">برروزرسانی</button>
        </form>
    </div>
@endsection








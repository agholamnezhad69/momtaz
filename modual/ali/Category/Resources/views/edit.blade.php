@extends("Dashboard::master")

@section('breadcrumb')
    <li><a href="{{route('categories.index')}}" title="دسته بندی">دسته بندی</a></li>
    <li><a href="#" title=" ویرایش دسته بندی"> ویرایش دسته بندی</a></li>
@endsection

@section('content')
    <div class="row no-gutters  ">
        <div class="col-4 bg-white">
            <p class="box__title">بروزرسانی دسته</p>
            <form action="{{route('categories.update',$category->id)}}" method="post" class="padding-30">
                @csrf
                @method('patch')
                <input type="text" name="title" placeholder="نام دسته بندی" class="text" value="{{$category->title}}">
                <input type="text" name="slug" placeholder="نام انگلیسی دسته بندی" class="text"
                       value="{{$category->slug}}">
                <p class="box__title margin-bottom-15">انتخاب دسته پدر</p>
                <select name="parent_id" id="">
                    <option value="">ندارد</option>
                    @foreach($categories as $catItem)
                        <option value="{{$catItem->id}}"
                                @if($catItem->id==$category->parent_id) selected @endif>{{$catItem->title}}</option>
                    @endforeach
                </select>
                <button class="btn btn-brand">بروزرسانی</button>
            </form>
        </div>
    </div>
@endsection

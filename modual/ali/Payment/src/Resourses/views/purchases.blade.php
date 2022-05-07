@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{route('purchases.index')}}" title="خریدهای من">خریدهای من</a></li>
@endsection


@section('content')
    <div class="main-content">
        <div class="table__box">
            <table class="table">
                <thead>
                <tr class="title-row">
                    <th>عنوان دوره</th>
                    <th>تاریخ پرداخت</th>
                    <th>مقدار پرداختی</th>
                    <th>وضعیت پرداخت</th>
                </tr>
                </thead>
                <tbody>
                @foreach($purchases as $purchase)
                    <tr>
                        <td>{{$purchase->paymentable->title}}</td>
                        <td>{{createJalaliFromCarbon($purchase->created_at)}}</td>
                        <td>{{number_format($purchase->amount)}}</td>
                        <td class="{{$purchase->status == \ali\Payment\Models\Payment::STATUS_SUCCESS ? 'text-success':'text-error' }}">@lang($purchase->status)</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$purchases->render()}}
        </div>
        <div class="pagination">
            محل قرار گیری صفحه بندی

        </div>
    </div>
@endsection








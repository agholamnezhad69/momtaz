@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{route('payments.index')}}" title="تراکنش ها">تراکنش ها</a></li>
@endsection


@section('content')
    <div class="main-content font-size-13">
        <div class="row no-gutters  margin-bottom-10">
            <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                <p>کل فروش ۳۰ روز گذشته سایت </p>
                <p>{{number_format($last30DayTotals)}} تومان </p>
            </div>
            <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                <p>درامد خالص ۳۰ روز گذشته سایت</p>
                <p>{{number_format($last30DayBenefitSiteShare)}} تومان </p>
            </div>
            <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                <p>کل فروش سایت</p>
                <p>{{number_format($totalSell)}} تومان </p>
            </div>
            <div class="col-3 padding-20 border-radius-3 bg-white margin-bottom-10">
                <p> کل درآمد خالص سایت</p>
                <p>{{number_format($totalBenefit)}} تومان </p>
            </div>
        </div>
        <div class="row no-gutters border-radius-3 font-size-13">
            <div class="col-12 bg-white padding-30 margin-bottom-20">
                <figure class="highcharts-figure">
                    <div id="container"></div>
                </figure>
            </div>

        </div>
        <div class="d-flex flex-space-between item-center flex-wrap padding-30 border-radius-3 bg-white">
            <p class="margin-bottom-15">همه تراکنش ها</p>
            <div class="t-header-search">
                <form action="">
                    <div class="t-header-searchbox font-size-13">
                        <div type="text" class="text search-input__box ">جستجوی دوره</div>
                        <div class="t-header-search-content ">
                            <input type="text" class="text" name="email" value="{{request("email")}}"
                                   placeholder="ایمیل">
                            <input type="text" class="text" name="amount" value="{{request("amount")}}"
                                   placeholder="مبلغ به تومان">
                            <input type="text" class="text" name="invoice_id" value="{{request("invoice_id")}}"
                                   placeholder="شماره">
                            <input type="text" class="text" name="start_date" id="start_date"
                                   value="{{request("start_date")}}"
                                   placeholder="از تاریخ : 1399/10/11">
                            <input type="text" class="text margin-bottom-20" name="end_date" id="end_date"
                                   value="{{request("end_date")}}"
                                   placeholder="تا تاریخ : 1399/10/12">
                            <button class="btn btn-success">جستجو</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <div class="table__box">
            <table width="100%" class="table">
                <thead role="rowgroup">
                <tr role="row" class="title-row">
                    <th>شناسه پرداخت</th>
                    <th>شماره تراکنش</th>
                    <th>نام و نام خانوادگی</th>
                    <th>ایمیل پرداخت کننده</th>
                    <th>مبلغ (تومان)</th>
                    <th>درامد شما</th>
                    <th>درامد سایت</th>
                    <th>نام دوره</th>
                    <th>تاریخ و ساعت</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>

                @foreach($payments as $payment)


                    <tr role="row">
                        <td><a href=""> {{$payment->id}}</a></td>
                        <td><a href="">{{$payment->invoice_id}}</a></td>
                        <td><a href="">{{$payment->buyer->name}}</a></td>
                        <td><a href="">{{$payment->buyer->email}}</a></td>

                        <td><a href="">{{number_format($payment->amount)}}</a></td>
                        <td><a href="">{{number_format($payment->seller_share)}}</a></td>
                        <td><a href="">{{number_format($payment->site_share)}}</a></td>

                        <td><a href="">{{$payment->paymentable->title}}</a></td>

                        <td><a href=""> {{\Morilog\Jalali\Jalalian::fromCarbon($payment->created_at)}}</a></td>
                        <td>
                            <a href=""
                               class="
                                @if ($payment->status == \ali\Payment\Models\Payment::STATUS_SUCCESS)
                                   text-success
                                   @elseif($payment->status == \ali\Payment\Models\Payment::STATUS_FAIL)
                                   text-error
                                  @endif">
                                @lang($payment->status)
                            </a>
                        </td>
                        <td>
                            <a href="" class="item-delete mlg-15"></a>
                            <a href="edit-transaction.html" class="item-edit"></a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            {{$payments->render()}}
        </div>
    </div>
@endsection

@section('bootstrap_css')
    <link rel="stylesheet" href="/assets/persianDataPicker/css/bootstrap.min.css">
@endsection
@section('css')
    <link rel="stylesheet" href="/assets/persianDataPicker/css/jquery.md.bootstrap.datetimepicker.style.css"/>
@endsection
@section('js')
    @include("Payment::chart");
    <script src="/assets/persianDataPicker/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/persianDataPicker/js/jquery.md.bootstrap.datetimepicker.js"></script>
    <script type="text/javascript">
        $('#start_date').MdPersianDateTimePicker({
            targetTextSelector: '#start_date',

        });
        $('#end_date').MdPersianDateTimePicker({
            targetTextSelector: '#end_date',
        });
    </script>

@endsection








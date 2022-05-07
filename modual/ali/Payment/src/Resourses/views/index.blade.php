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
                <form action="" onclick="event.preventDefault();">
                    <div class="t-header-searchbox font-size-13">
                        <div type="text" class="text search-input__box ">جستجوی دوره</div>
                        <div class="t-header-search-content ">
                            <input type="text" class="text" placeholder="شماره کارت / بخشی از شماره کارت">
                            <input type="text" class="text" placeholder="ایمیل">
                            <input type="text" class="text" placeholder="مبلغ به تومان">
                            <input type="text" class="text" placeholder="شماره">
                            <input type="text" class="text" placeholder="از تاریخ : 1399/10/11">
                            <input type="text" class="text margin-bottom-20" placeholder="تا تاریخ : 1399/10/12">
                            <btutton class="btn btn-brand">جستجو</btutton>
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
                        <td><a href="">{{$payment->buyer->name}}</a></td>
                        <td><a href="">{{$payment->buyer->email}}</a></td>

                        <td><a href="">{{number_format($payment->amount)}}</a></td>
                        <td><a href="">{{number_format($payment->seller_share)}}</a></td>
                        <td><a href="">{{number_format($payment->site_share)}}</a></td>

                        <td><a href="">{{$payment->paymentable->title}}</a></td>
                        <td><a href=""> {{$payment->created_at}}</a></td>
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
        </div>
    </div>
@endsection


@section('js')

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>
        Highcharts.chart('container', {
            title: {
                text: 'نمودار فروش 30 روز گذشته'
            },
            tooltip: {
                useHTML: true,
                style: {
                    fontSize: '20px',
                    fontFamily: 'tahoma',
                    direction: 'rtl',
                },
                formatter: function () {
                    return (this.x ? "تاریخ: " + this.x + "<br>" : "") + "مبلغ: " + this.y
                }
            },
            xAxis: {

                categories: [
                    @foreach($dates as $date=>$value)

                        '  {{$date}} ',

                    @endforeach]
            },
            yAxis: {
                title: {
                    text: 'مبلغ'
                },
                labels: {
                    formatter: function () {
                        return this.value + 'تومان'
                    }
                }
            },
            labels: {
                items: [{
                    html: 'درآمد 30 روز گذشته',
                    style: {
                        left: '50px',
                        top: '18px',
                        color: ( // theme
                            Highcharts.defaultOptions.title.style &&
                            Highcharts.defaultOptions.title.style.color
                        ) || 'black'
                    }
                }]
            },
            series: [{
                type: 'column',
                name: 'تراکنش موفق',
                data: [
                    @foreach($dates as $date=>$value)

                        @if( $day=$summery->where('date',$date)->first())

                        {{$day->totalAmount}},
                    @else
                        0,
                    @endif

                    @endforeach
                ]
            }
                ,
                {
                    type: 'column',
                    name: 'درصد سایت',
                    data: [
                        @foreach($dates as $date=>$value)

                            @if( $day=$summery->where('date',$date)->first())

                            {{$day->totalSiteShare}},
                        @else
                            0,
                        @endif

                        @endforeach

                    ]
                }
                ,
                    {
                        type: 'column',
                        name: 'درصد مدرس',
                        data: [
                            @foreach($dates as $date=>$value)

                                @if( $day=$summery->where('date',$date)->first())

                                {{$day->totalSellerShare}},
                            @else
                                0,
                            @endif

                            @endforeach
                        ]
                    }
                    , {
                        type: 'spline',
                        name: 'فروش',
                        data: [
                            @foreach($dates as $date=>$value)

                                @if( $day=$summery->where('date',$date)->first())

                                {{$day->totalAmount}},
                            @else
                                0,
                            @endif

                            @endforeach
                        ],
                        marker: {
                            lineWidth: 2,
                            lineColor: Highcharts.getOptions().colors[3],
                            fillColor: 'white'
                        }
                    },
                {
                    type: 'pie',
                    name: 'Total consumption',
                    data: [{
                            name: 'درصد سایت',
                            y: {{$last30DayBenefitSiteShare}},
                            color: Highcharts.getOptions().colors[0] // Jane's color
                        }, {
                            name: 'درصد مدرس',
                            y: {{$last30DayBenefitSellerShare}},
                            color: Highcharts.getOptions().colors[1] // John's color
                        }],
                    center: [100, 80],
                    size: 100,
                    showInLegend: false,
                    dataLabels: {
                        enabled: false
                    }
                }

            ]
        });
    </script>

@endsection





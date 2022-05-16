<?php

namespace ali\Payment\Http\Controllers;


use ali\Payment\Http\Requests\SettlementRequest;

use ali\Payment\Models\Settlement;
use ali\Payment\Repositories\SettlementRepo;
use ali\Payment\Services\SettlementService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class SettlementController extends Controller
{

    public function index(SettlementRepo $settlementRepo)
    {
        $settlements = $settlementRepo->paginate();
        return view("Payment::settlements.index", compact('settlements'));

    }

    public function create(SettlementRepo $settlementRepo)
    {
        if ($settlementRepo->getLatestPendingSettlement(auth()->id())) {
            newFeedbacks("ناموفق", "شما یک درخواست تسویه در حال انتظار دارید و نمیتوانید درخواست جدیدی فعلا ثبت بکنید.", "error");
            return redirect()->route('settlements.index');
            // return redirect(route('settlements.index'));
            //  return back();

        }
        return view("Payment::settlements.create");
    }

    public function store(SettlementRequest $settlementRequest, SettlementRepo $settlementRepo)
    {

        if ($settlementRepo->getLatestPendingSettlement(auth()->id())) {
            newFeedbacks("ناموفق", "شما یک درخواست تسویه در حال انتظار دارید و نمیتوانید درخواست جدیدی فعلا ثبت بکنید.", "error");
            return redirect()->route('settlements.index');

        }

        SettlementService::store($settlementRequest->all());
        return redirect(route('settlements.index'));

    }

    public function edit($settlement_id, SettlementRepo $settlementRepo)
    {

        $requestedSettlement = $settlementRepo->findById($settlement_id);
        $settlement = $settlementRepo->getLatestSettlement($requestedSettlement->user_id);

        if ($settlement->id != $settlement_id) {
            newFeedbacks("ناموفق", "این درخواست تسویه قابل ویرایش نیست و بایگانی شده است. فقط آخرین درخواست تسویه ی هر کاربر قابل ویرایش است.", "error");
            return redirect()->route("settlements.index");
        }


        return view("Payment::settlements.edit", compact('settlement'));

    }

    public function update($settlement_id, SettlementRequest $settlementRequest)
    {

        SettlementService::update($settlement_id, $settlementRequest->all());
        return redirect(route("settlements.index"));


    }
}

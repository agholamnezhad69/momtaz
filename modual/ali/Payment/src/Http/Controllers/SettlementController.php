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

    public function create()
    {
        return view("Payment::settlements.create");
    }

    public function store(SettlementRequest $settlementRequest)
    {

        SettlementService::store($settlementRequest->all());
        return redirect(route('settlements.index'));

    }

    public function edit($settlement_id, SettlementRepo $settlementRepo)
    {
        $settlement = $settlementRepo->findById($settlement_id);


        return view("Payment::settlements.edit", compact('settlement'));

    }

    public function update($settlement_id, SettlementRequest $settlementRequest)
    {

        SettlementService::update($settlement_id, $settlementRequest->all());
        return redirect(route("settlements.index"));


    }
}

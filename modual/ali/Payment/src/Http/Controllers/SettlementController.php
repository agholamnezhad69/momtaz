<?php

namespace ali\Payment\Http\Controllers;


use ali\Payment\Http\Requests\SettlementRequest;

use ali\Payment\Models\Settlement;
use ali\Payment\Repositories\SettlementRepo;
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

    public function store(SettlementRequest $request, SettlementRepo $settlementRepo)
    {

        $settlementRepo->store($request->all());

        auth()->user()->balance -= $request->amount;
        auth()->user()->save();
        newFeedbacks();
        return redirect(route('settlements.index'));


    }

    public function edit($settlement_id, SettlementRepo $settlementRepo)
    {
        $settlement = $settlementRepo->findById($settlement_id);


        return view("Payment::settlements.edit", compact('settlement'));

    }

    public function update($settlement_id, SettlementRequest $settlementRequest, SettlementRepo $settlementRepo)
    {


        $settlementRepo->update($settlement_id, $settlementRequest->all());

        newFeedbacks();
        return redirect(route("settlements.index"));


    }
}

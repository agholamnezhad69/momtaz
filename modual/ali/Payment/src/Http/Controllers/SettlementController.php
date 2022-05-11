<?php

namespace ali\Payment\Http\Controllers;


use ali\Payment\Http\Requests\SettlementRequest;

use ali\Payment\Models\Settlement;
use ali\Payment\Repositories\SettlementRepo;
use App\Http\Controllers\Controller;


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

        $settlementRepo->store([
                'cart' => $request->cart,
                'name' => $request->name,
                'amount' => $request->amount
            ]
        );
        newFeedbacks();
        return redirect(route('settlements.index'));


    }
}

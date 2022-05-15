<?php

namespace ali\Payment\Services;

use ali\Payment\Gateways\Gateway;
use ali\Payment\Models\Payment;
use ali\Payment\Models\Settlement;
use ali\Payment\Repositories\PaymentRepo;
use ali\Payment\Repositories\SettlementRepo;
use ali\User\Models\User;

class SettlementService
{
    public static function store(array $data)
    {
        $settlementRepo = new SettlementRepo();
        $settlementRepo->store($data);

        auth()->user()->balance -= $data['amount'];
        auth()->user()->save();

        newFeedbacks();
    }

    public static function update(int $settlement_id, array $data)
    {

        $settlementRepo = new SettlementRepo();
        $settlement = $settlementRepo->findById($settlement_id);
        if (
            !in_array($settlement->status, [Settlement::STATUS_CANCELED, Settlement::STATUS_REJECTED])
            &&
            in_array($data['status'], [Settlement::STATUS_CANCELED, Settlement::STATUS_REJECTED])) {


            $settlement->user->balance += $data["amount"];
            $settlement->user->save();

        }
        if (in_array($settlement->status, [Settlement::STATUS_CANCELED, Settlement::STATUS_REJECTED])
            &&
            in_array($data['status'], [Settlement::STATUS_SETTLED, Settlement::STATUS_PENDING])
        ) {


            $settlement->user->balance -= $data["amount"];
            $settlement->user->save();

        }


        $settlementRepo->update($settlement_id, $data);
        newFeedbacks();
    }

}

<?php


namespace ali\Payment\Repositories;


use ali\Payment\Models\Settlement;

class SettlementRepo
{

    private $query;

    public function __construct()
    {

        $this->query = Settlement::query();
    }

    public function store($request)
    {

        return Settlement::query()
            ->create([
                "user_id" => auth()->id(),
                "to" => [
                    "cart" => $request["cart"],
                    "name" => $request["name"],
                ],
                "amount" => $request["amount"],
            ]);
    }

    public function findById($settlement_id)
    {
        return $this->query->findOrFail($settlement_id);


    }

    public function paginate()
    {
        return $this->query->latest()->paginate();
    }

    public function update($settlement_id, $request)
    {

        return $this->query->where('id', $settlement_id)->update([

                "from" => [
                    "name" => $request["from"]['name'],
                    "cart" => $request["from"]['cart'],
                ],
                "to" => [
                    "name" => $request["to"]["name"],
                    "cart" => $request["to"]["cart"],
                ],
                "status" => $request["status"]
            ]
        );

    }


}
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

    public function store($data)
    {

        return Settlement::query()
            ->create([
                "user_id" => auth()->id(),
                "to" => [
                    "cart" => $data["cart"],
                    "name" => $data["name"],
                ],
                "amount" => $data["amount"],
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

    public function update($data)
    {
        $this->query->update([
            "user_id"=>auth()->id(),
            "from"
        ]);

    }


}

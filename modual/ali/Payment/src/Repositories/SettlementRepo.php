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

    public function paginate()
    {
        return $this->query->latest()->paginate();
    }

    public function joinUsers()
    {
        $this->query
            ->join("users", "settlements.user_id", "users.id")
            ->select("settlements.*", "users.id as userId", "users.name", "users.email");

        return $this;
    }

    public function searchStatus($status)
    {
        if (!is_null($status))
            $this->query->where('settlements.status', "=", $status);
        return $this;
    }

    public function searchToCart($toCart)
    {
        if (!is_null($toCart))
            $this->query->whereJsonContains("to", ['cart' => $toCart]);
        return $this;
    }

    public function searchFromCart($fromCart)
    {
        if (!is_null($fromCart))
            $this->query->whereJsonContains("from", ['cart' => $fromCart]);
        return $this;

    }

    public function searchDate($date)
    {
        if (!is_null($date))
            $this->query
                ->whereDate("settlements.created_at", "=", getDateFromJalaliToCarbon(convertPersianNumberToEnglish($date)));
        return $this;
    }

    public function searchEmail($email)
    {
        if (!is_null($email))
            $this->query->where("email", "like", "%" . $email . "%");


        return $this;


    }

    public function searchName($name)
    {
        if (!is_null($name))
            $this->query->where("name", "like", "%" . $name . "%");


        return $this;


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


    public function update(int $settlement_id, array $request)
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


    public function getLatestPendingSettlement($user_id)
    {

        return Settlement::query()
            ->where('user_id', $user_id)
            ->where('status', Settlement::STATUS_PENDING)
            ->latest()
            ->first();

    }

    public function getLatestSettlement($user_id)
    {

        return Settlement::query()
            ->where('user_id', $user_id)
            ->latest()
            ->first();

    }

    public function paginateUserSettlements($userId)
    {
        return $this->query
            ->where('user_id', $userId)
            ->latest()
            ->paginate();

    }


}

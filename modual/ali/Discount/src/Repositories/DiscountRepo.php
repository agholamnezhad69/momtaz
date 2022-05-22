<?php

namespace ali\Discount\Repositories;

use ali\Discount\Models\Discount;
use ali\Payment\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Morilog\Jalali\Jalalian;


class DiscountRepo
{

    public function Store($data)
    {


        $discount = Discount::query()
            ->create([
                "user_id" => auth()->id(),
                "code" => $data["code"],
                "percent" => $data["percent"],
                "usage_limitation" => $data["usage_limitation"],
                "expire_at" => $data["expire_at"] ?
                    Jalalian::fromFormat("Y/m/d H:i:s",
                        str_replace("  ", "",
                            convertPersianNumberToEnglish($data["expire_at"])))->toCarbon() : null,
                "link" => $data["link"],
                "type" => $data["type"],
                "description" => $data["description"]
            ]);

        if ($discount->type == Discount::TYPE_SPECIAL) {

            $discount->courses()->sync(isset($data['courses']) ? $data['courses'] : []);
        }

    }

    public function paginateAll()
    {
        return Discount::query()
            ->latest()
            ->paginate();


    }


    public function update($discount_id, array $data)
    {

        Discount::query()
            ->where('id', $discount_id)
            ->update([
                "code" => $data["code"],
                "percent" => $data["percent"],
                "usage_limitation" => $data["usage_limitation"],
                "expire_at" => $data["expire_at"] ?
                    Jalalian::fromFormat("Y/m/d H:i:s",
                        str_replace("  ", "",
                            convertPersianNumberToEnglish($data["expire_at"])))->toCarbon() : null,
                "link" => $data["link"],
                "type" => $data["type"],
                "description" => $data["description"]
            ]);

        $discount = $this->find($discount_id);

        if ($discount->type == Discount::TYPE_SPECIAL) {
            $discount->courses()->sync(isset($data['courses']) ? $data['courses'] : []);
        } else {
            $discount->courses()->sync([]);
        }


    }

    public function find($id)
    {
        return Discount::query()->find($id);
    }

}

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


        return Discount::query()
            ->create([
                "user_id" => auth()->id(),
                "code" => $data["code"],
                "percent" => $data["percent"],
                "usage_limitation" => $data["usage_limitation"],
                "expire_at" => Jalalian::fromFormat("Y/m/d H:i:s",
                    str_replace("  ", "",
                        convertPersianNumberToEnglish($data["expire_at"]
                        )))->toCarbon(),
                "link" => $data["link"],
                "description" => $data["description"]
            ]);

    }

    public function paginateAll()
    {
        return Discount::query()
            ->latest()
            ->paginate();


    }

}

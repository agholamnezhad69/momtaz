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

    public function getValidDiscountQuery($type = Discount::TYPE_ALL, $courseId = null)
    {
        $query = Discount::query()
            ->where("expire_at", ">", now())
            ->where('type', $type);
        if ($courseId) {
            $query->whereHas('courses', function ($query) use ($courseId) {
                $query->where('id', $courseId);
            });
        }
        $query->where(function ($query) {
            $query->Where("usage_limitation", ">", 0)
                ->orWhereNull("usage_limitation");
        })
            ->orderBy('percent', 'desc');
        return $query;
    }

    public function getGlobalBiggerDiscount()
    {
        return $this->getValidDiscountQuery()->first();

    }


    public function getCourseBiggerDiscount($courseId)
    {
        return $this->getValidDiscountQuery(Discount::TYPE_SPECIAL, $courseId)->first();;

    }

}

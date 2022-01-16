<?php

namespace ali\Course\Repositories;

use ali\Course\Models\Course;
use Illuminate\Support\Str;

class CourseRepo
{

    public function store($values)
    {

        return Course::create([

            'teacher_id' => $values->teacher_id,
            'category_id' => $values->category_id,
            'banner_id' => $values->banner_id,
            'title' => $values->title,
            'slug' => Str::slug($values->slug),
            'priority' => $values->priority,
            'price' => $values->price,
            'percent' => $values->percent,
            'type' => $values->type,
            'statues' => $values->status,
            'body' => $values->body,
            'confirmation_status' => Course::CONFIRMATION_STATUS_PENDING,


        ]);

    }

    public function paginate()
    {

        return Course::paginate();

    }

    public function findById($id)
    {

        return Course::query()->findOrFail($id);
    }

    public function update($id, $values)
    {
        Course::query()->where('id', $id)->update([
            'teacher_id' => $values->teacher_id,
            'category_id' => $values->category_id,
            'banner_id' => $values->banner_id,
            'title' => $values->title,
            'slug' => $values->slug,
            'priority' => $values->priority,
            'price' => $values->price,
            'percent' => $values->percent,
            'type' => $values->type,
            'statues' => $values->status . "",
            'body' => $values->body,
        ]);
    }

    public function updateConfirmationStatus($id, string $status)
    {

        return Course::query()
            ->where('id', $id)
            ->update(["confirmation_status" => $status]);


    }

    public function updateStatus($id, string $status)
    {
        return Course::query()
            ->where('id', $id)
            ->update(["statues" => $status]);

    }


}
<?php


namespace ali\Category\Repositories;


use ali\Category\Models\Category;

class CategoryRepo
{
    public function all()
    {
        return Category::all();
    }

    public function allExceptById($catId)
    {
        return $this->all()->filter(function ($item) use ($catId) {

            return $item->id != $catId;
        });
    }

    public function store($values)
    {
        return Category::create([
            'title' => $values->title,
            'slug' => $values->slug,
            'parent_id' => $values->parent_id,

        ]);
    }

    public function finById($catId)
    {
        return Category::query()->findOrFail($catId);
    }

    public function update($catId, $values)
    {
        Category::query()->where('id', $catId)->update([
            'title' => $values->title,
            'slug' => $values->slug,
            'parent_id' => $values->parent_id,
        ]);
    }

    public function delete($catId)
    {
        Category::query()->where('id', $catId)->delete();
    }


}

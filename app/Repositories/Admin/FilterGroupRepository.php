<?php

namespace App\Repositories\Admin;


use App\Repositories\CoreRepository;
use App\Models\Admin\AttributeGroup as Model;

class FilterGroupRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

/** Get all groups filter */
    public function getAllGroupsFilter()
    {
        $attrs_group = \DB::table('attribute_groups')->get()->all();
        return $attrs_group;
    }

    /** Get info by id */
    public function getInfoProduct($id)
    {
        $product = $this->startConditions()->find($id);
        return $product;
    }

    /** Delete one group filter by id */
    public function deleteGroupFilter($id)
    {
        $group = $this->startConditions()->where('id', $id)->forceDelete();
        return $group;
    }

    /** Count all groups filter */
    public function getCountGroupFilter()
    {
        $count = \DB::table('attribute_values')->count();
        return $count;
    }

}
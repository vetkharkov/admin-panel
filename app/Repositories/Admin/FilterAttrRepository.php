<?php

namespace App\Repositories\Admin;


use App\Repositories\CoreRepository;
use App\Models\Admin\AttributeValue as Model;

class FilterAttrRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    /** Get count attributes filter by id */
    public function getCountFilterAttrsById($id)
    {
        $count = \DB::table('attribute_values')
            ->where('attr_group_id', $id)
            ->count();
        return $count;
    }

    /** Get all attribute filter with name group */
    public function getAllAttrsFilter()
    {
        $attrs = \DB::table('attribute_values')
            ->join('attribute_groups', 'attribute_groups.id', '=', 'attribute_values.attr_group_id')
            ->select('attribute_values.*', 'attribute_groups.title')
            ->paginate(15);
        return $attrs;
    }

    /** Check unique name for add new attribute
     * @param $name
     * @return $unique
     */
    public function checkUnique($name)
    {
        $unique = $this->startConditions()->where('value', $name)->count();
        return $unique;
    }

    /** Get info by id */
    public function getInfoProduct($id)
    {
        $product = $this->startConditions()->find($id);
        return $product;
    }

    /** Delete one attribute filter by id */
    public function deleteAttrFilter($id)
    {
        $delete = $this->startConditions()->where('id', $id)->forceDelete();
        return $delete;
    }

}
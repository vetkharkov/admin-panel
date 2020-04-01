<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AttributeGroup extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attribute_groups';

    public $timestamps = false;

    protected $fillable = [
        'title',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AttributeGroup extends Model
{
    public $table = 'attribute_groups';

    public $fillable = [
        'sort_order'
    ];

    protected $casts = [

    ];

    public static array $rules = [
        'sort_order' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function descriptions(): HasMany
    {
        return $this->hasMany(AttributeGroupDescription::class, 'attribute_group_id');
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(Attribute::class, 'attribute_group_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Information extends Model
{
    public $table = 'informations';

    public $fillable = [
        'sort_order',
        'status',
        'show_blocks'
    ];

    protected $casts = [
        'show_blocks' => 'boolean'
    ];

    public static array $rules = [
        'sort_order' => 'required',
        'status' => 'required',
        'show_blocks' => 'required|boolean',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function firstPathQuery()
    {
        return $this->hasOne(FirstPathQuery::class, 'type_id')->where('type', 'information');
    }

    public function descriptions(): HasMany
    {
        return $this->hasMany(InformationDescription::class, 'information_id');
    }
}

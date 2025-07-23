<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function informationDescription()
    {
        return $this->hasOne(InformationDescription::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FilterDescription extends Model
{
    public $table = 'filter_descriptions';

    public $fillable = [
        'language_id',
        'name',
        'meta_title'
    ];

    protected $casts = [
        'name' => 'string',
        'meta_title' => 'string'
    ];

    public static array $rules = [
        'language_id' => 'required',
        'name' => 'required|string|max:255',
        'meta_title' => 'required|string|max:255'
    ];

    public function filter(): BelongsTo
    {
        return $this->belongsTo(Filter::class, 'filter_id');
    }
}

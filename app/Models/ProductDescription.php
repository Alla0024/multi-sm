<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductDescription extends Model
{
    public $table = 'product_descriptions';

    public $fillable = [
        'product_id',
        'language_id',
        'name',
        'description',
        'meta_title',
        'meta_description',
        'damage_comment',
        'tag',
        'type',
        'comment_to_oversize'
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'meta_title' => 'string',
        'meta_description' => 'string',
        'damage_comment' => 'string',
        'tag' => 'string',
        'type' => 'string',
        'comment_to_oversize' => 'string'
    ];

    public static array $rules = [
        'product_id' => 'required',
        'language_id' => 'required',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'meta_title' => 'required|string|max:255',
        'meta_description' => 'required|string|max:255',
        'damage_comment' => 'nullable|string',
        'tag' => 'nullable|string|max:255',
        'type' => 'required|string|max:255',
        'comment_to_oversize' => 'nullable|string|max:255'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}

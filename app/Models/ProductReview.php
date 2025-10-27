<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    public $table = 'product_reviews';

    public $fillable = [
        'product_id',
        'author',
        'text',
        'advantages',
        'limitations',
        'answer',
        'rating',
        'status',
        'type',
        'helpful',
        'unhelpful',
        'date_value',
        'author_answer'
    ];

    protected $casts = [
        'author' => 'string',
        'text' => 'string',
        'advantages' => 'string',
        'limitations' => 'string',
        'answer' => 'string',
        'helpful' => 'string',
        'unhelpful' => 'string',
        'date_value' => 'datetime',
        'author_answer' => 'string'
    ];

    public static array $rules = [
        'product_id' => 'required',
        'author' => 'required|string|max:255',
        'text' => 'required|string|max:65535',
        'advantages' => 'nullable|string|max:65535',
        'limitations' => 'nullable|string|max:65535',
        'answer' => 'nullable|string|max:65535',
        'rating' => 'required',
        'status' => 'required',
        'type' => 'required',
        'helpful' => 'nullable|string|max:255',
        'unhelpful' => 'nullable|string|max:255',
        'date_value' => 'nullable',
        'author_answer' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id')->with('path');
    }

    public function productDescription()
    {
        return $this->belongsTo(ProductDescription::class, 'product_id', 'product_id')
            ->where('language_id', config('settings.locale.default_language_id'));
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewsToCategory extends Model
{
    public $table = 'new_to_categories';

    public $fillable = [
        'category_id',
        'sort_order'
    ];

    protected $casts = [

    ];

    public static array $rules = [
        'category_id' => 'required',
        'sort_order' => 'required'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function new(): BelongsTo
    {
        return $this->belongsTo(News::class, 'new_id');
    }
}

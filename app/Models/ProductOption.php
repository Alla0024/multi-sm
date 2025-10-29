<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Thiagoprz\CompositeKey\HasCompositeKey;

class ProductOption extends Model
{
    use HasCompositeKey;

    public $table = 'product_options';
    public $timestamps = false;
    protected $primaryKey = ['product_id', 'option_id'];

    public $fillable = [
        'product_id',
        'option_id',
        'c1',
        'hash',
        'image_change',
        'hide_option'
    ];

    protected $casts = [
        'c1' => 'string',
        'hash' => 'string',
        'image_change' => 'boolean'
    ];

    public static array $rules = [
        'option_id' => 'required',
        'c1' => 'nullable|string|max:255',
        'hash' => 'nullable|string|max:255',
        'image_change' => 'required|boolean',
        'hide_option' => 'required'
    ];

    public function option()
    {
        return $this->belongsTo(Option::class, 'option_id')->with('description');
    }
    public function descriptions()
    {
        return $this->hasMany(ProductOptionDescription::class, 'option_id', 'option_id');
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id');
    }
}

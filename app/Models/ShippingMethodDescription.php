<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShippingMethodDescription extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $table = 'shipping_method_descriptions';

    public $incrementing = false;

    public $fillable = [
        'shipping_method_id',
        'language_id',
        'title',
        'comment',
        'condition'
    ];

    protected $casts = [
        'shipping_method_id' => 'integer',
        'language_id' => 'integer',
        'title' => 'string',
        'comment' => 'string',
        'condition' => 'string'
    ];

    public static array $rules = [
        'shipping_method_id' => 'required|exists:shipping_methods,id',
        'language_id' => 'required',
        'title' => 'required',
    ];
    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class, 'shipping_method_id');
    }
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}

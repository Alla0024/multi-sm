<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Manufacturer extends Model
{
    use HasFactory;

    public $table = 'manufacturers';

    public $fillable = [
        'image',
        'sort_order'
    ];

    protected $casts = [
        'image' => 'string',
        'sort_order' => 'integer'
    ];

    public static array $rules = [
        'image' => 'required',
        'sort_order' => 'required'
    ];

    public function descriptions(): HasMany
    {
        return $this->hasMany(ManufacturerDescription::class, 'manufacturer_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'manufacturer_id');
    }
    public function seoPath()
    {
        return $this->hasOne(FirstPathQuery::class, 'type_id')->where('type', 'manufacturer');
    }
}

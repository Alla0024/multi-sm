<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

class ManufacturerToStore extends Model
{
    use HasCompositeKey;

    public $table = 'manufacturer_to_stores';

    public $timestamps = false;

    protected $primaryKey = [
        'manufacturer_id',
        'store_id'
    ];

    public $fillable = [
        'manufacturer_id',
        'store_id'
    ];

    protected $casts = [
    ];

    public static array $rules = [
        'store_id' => 'required',
        'manufacturer_id' => 'required',
    ];

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

class SaleToStore extends Model
{
    use HasCompositeKey;

    public $table = 'sale_to_stores';

    public $timestamps = false;

    protected $primaryKey = [
        'sale_id',
        'store_id'
    ];

    public $fillable = [
        'sale_id',
        'store_id'
    ];

    protected $casts = [
    ];

    public static array $rules = [
        'store_id' => 'required',
        'sale_id' => 'required',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

class SaleGroupToSale extends Model
{
    use HasCompositeKey;

    public $table = 'sale_group_to_sales';

    public $timestamps = false;

    protected $primaryKey = [
        'sale_group_id',
        'sale_id'
    ];

    public $fillable = [
        'sale_group_id',
        'sale_id'
    ];

    protected $casts = [
    ];

    public static array $rules = [
        'sale_group_id' => 'required',
        'sale_id' => 'required',
    ];

    public function saleGroup(): BelongsTo
    {
        return $this->belongsTo(SaleGroup::class, 'sale_group_id');
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }
}

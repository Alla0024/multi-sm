<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

class SegmentToProduct extends Model
{
    use HasCompositeKey;

    public $table = 'segment_to_product';

    public $timestamps = false;

    protected $primaryKey = [
        'product_id',
        'segment_id'
    ];

    public $fillable = [
        'product_id',
        'segment_id'
    ];

    protected $casts = [
    ];

    public static array $rules = [
        'segment_id' => 'required',
        'product_id' => 'required',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function segment(): BelongsTo
    {
        return $this->belongsTo(Segment::class, 'segment_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

class SaleToSegment extends Model
{
    use HasCompositeKey;

    public $table = 'sale_to_segments';

    public $timestamps = false;

    protected $primaryKey = [
        'sale_id',
        'segment_id'
    ];

    public $fillable = [
        'sale_id',
        'segment_id'
    ];

    protected $casts = [
    ];

    public static array $rules = [
        'segment_id' => 'required',
        'sale_id' => 'required',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function segment(): BelongsTo
    {
        return $this->belongsTo(Segment::class, 'segment_id');
    }
}

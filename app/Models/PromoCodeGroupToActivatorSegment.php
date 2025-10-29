<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

class PromoCodeGroupToActivatorSegment extends Model
{
    use HasCompositeKey;

    public $table = 'promo_code_group_to_activator_segments';

    public $timestamps = false;

    protected $primaryKey = [
        'promo_code_group_id',
        'segment_id'
    ];

    public $fillable = [
        'promo_code_group_id',
        'segment_id'
    ];

    protected $casts = [
    ];

    public static array $rules = [
        'segment_id' => 'required',
        'promo_code_group_id' => 'required',
    ];

    public function promoCodeGroup(): BelongsTo
    {
        return $this->belongsTo(PromoCodeGroup::class, 'promo_code_group_id');
    }

    public function segment(): BelongsTo
    {
        return $this->belongsTo(Segment::class, 'segment_id');
    }
}

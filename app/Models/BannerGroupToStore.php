<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

class BannerGroupToStore extends Model
{
    use HasCompositeKey;

    public $table = 'banner_group_to_stores';

    public $timestamps = false;

    protected $primaryKey = [
        'banner_group_id',
        'store_id'
    ];

    public $fillable = [
        'banner_group_id',
        'store_id'
    ];

    protected $casts = [
    ];

    public static array $rules = [
        'store_id' => 'required',
        'banner_group_id' => 'required',
    ];

    public function bannerGroup(): BelongsTo
    {
        return $this->belongsTo(BannerGroup::class, 'banner_group_id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}

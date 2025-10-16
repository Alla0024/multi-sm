<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockStatusDescription extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $table = 'stock_status_descriptions';

    public $incrementing = false;

    public $fillable = [
        'stock_status_id',
        'language_id',
        'name',
    ];

    protected $casts = [
        'stock_status_id' => 'integer',
        'language_id' => 'integer',
        'name' => 'string',
    ];

    public static array $rules = [
        'stock_status_id' => 'required|exists:stock_statuses,id',
        'language_id' => 'required',
        'name' => 'required',
    ];
    public function stockStatus()
    {
        return $this->belongsTo(StockStatus::class, 'stock_status_id');
    }
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}

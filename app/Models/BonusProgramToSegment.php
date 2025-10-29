<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

class BonusProgramToSegment extends Model
{
    use HasCompositeKey;

    public $table = 'bonus_program_to_segments';

    public $timestamps = false;

    protected $primaryKey = [
        'bonus_program_id',
        'segment_id'
    ];

    public $fillable = [
        'bonus_program_id',
        'segment_id'
    ];

    protected $casts = [
    ];

    public static array $rules = [
        'segment_id' => 'required',
        'bonus_program_id' => 'required',
    ];

    public function bonusProgram(): BelongsTo
    {
        return $this->belongsTo(BonusProgram::class, 'bonus_program_id');
    }

    public function segment(): BelongsTo
    {
        return $this->belongsTo(Segment::class, 'segment_id');
    }
}

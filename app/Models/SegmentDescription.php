<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SegmentDescription extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $table = 'segment_descriptions';

    public $incrementing = false;

    public $fillable = [
        'segment_id',
        'language_id',
        'name',
    ];

    protected $casts = [
        'segment_id' => 'integer',
        'language_id' => 'integer',
        'name' => 'string',
    ];

    public static array $rules = [
        'segment_id' => 'required|exists:segments,id',
        'language_id' => 'required',
        'name' => 'required',
    ];
    public function segment()
    {
        return $this->belongsTo(Segment::class, 'segment_id');
    }
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}

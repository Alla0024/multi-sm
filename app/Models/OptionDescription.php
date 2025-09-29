<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

class OptionDescription extends Model
{
    use HasCompositeKey;

    public $table = 'option_descriptions';
    public $timestamps = false;
    protected $primaryKey = ['option_id', 'language_id'];


    public $fillable = [
        'option_id',
        'language_id',
        'name',
        'comment'
    ];

    protected $casts = [
        'name' => 'string',
        'comment' => 'string'
    ];

    public static array $rules = [
        'language_id' => 'required',
        'name' => 'required|string|max:255',
        'comment' => 'nullable|string|max:255'
    ];

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class, 'option_id');
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}

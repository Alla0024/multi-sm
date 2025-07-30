<?php

namespace App\Models;

use App\Traits\SearchableBySimilarity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

class InformationDescription extends Model
{
    use SearchableBySimilarity, HasCompositeKey;

    public $table = 'information_descriptions';
    public $timestamps = false;
    protected $primaryKey = ['information_id', 'language_id'];

    public $fillable = [
        'information_id',
        'language_id',
        'name',
        'description'
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string'
    ];

    public static array $rules = [
        'information_id' => 'required',
        'language_id' => 'required',
        'name' => 'required|string|max:255',
        'description' => 'required|string'
    ];

    public function information(): BelongsTo
    {
        return $this->belongsTo(Information::class, 'information_id');
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}

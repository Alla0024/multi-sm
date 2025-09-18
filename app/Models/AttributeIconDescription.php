<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

class AttributeIconDescription extends Model
{
    use HasCompositeKey;
    public $table = 'attribute_icon_descriptions';
    protected $primaryKey = ['attribute_icon_id', 'language_id'];
    public $timestamps = false;

    public $fillable = [
        'attribute_icon_id',
        'language_id',
        'title',
        'description'
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string'
    ];

    public static array $rules = [
        'language_id' => 'required',
        'title' => 'required|string|max:255',
        'description' => 'required|string'
    ];

    public function attributeIcon(): BelongsTo
    {
        return $this->belongsTo(AttributeIcon::class, 'attribute_icon_id');
    }
}

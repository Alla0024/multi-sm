<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Language extends Model
{
    use HasFactory;

    public $table = 'languages';
    public $timestamps = false;

    public $fillable = [
        'code',
        'path',
        'status',
        'title',
        'sort_order'
    ];

    protected $casts = [
        'code' => 'string',
        'path' => 'string',
        'title' => 'string',
        'status' => 'boolean',
        'sort_order' => 'integer'
    ];

    public static array $rules = [
        'code' => 'required|max:5',
        'path' => 'nullable|max:5',
        'title' => 'required',
        'status' => 'required',
        'sort_order' => 'required'
    ];

    public static function getLanguages()
    {
        return Cache::rememberForever('languages', function () {
            return self::where('status', 1)
                ->orderBy('sort_order')
                ->get();
        });
    }
}

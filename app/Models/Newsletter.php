<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    public $table = 'newsletters';

    public $fillable = [
        'title',
        'type',
        'image',
        'viber_message',
        'sms_message',
        'button_text',
        'button_url',
        'phones',
        'start_in',
        'author',
        'status'
    ];

    protected $casts = [
        'title' => 'string',
        'type' => 'string',
        'image' => 'string',
        'viber_message' => 'string',
        'sms_message' => 'string',
        'button_text' => 'string',
        'button_url' => 'string',
        'phones' => 'string',
        'start_in' => 'datetime',
        'author' => 'string',
        'status' => 'boolean'
    ];

    public static array $rules = [
        'title' => 'required|string|max:255',
        'type' => 'nullable|string|max:50',
        'image' => 'nullable|string|max:255',
        'viber_message' => 'nullable|string|max:65535',
        'sms_message' => 'nullable|string|max:255',
        'button_text' => 'nullable|string|max:255',
        'button_url' => 'nullable|string|max:255',
        'phones' => 'nullable|string|max:65535',
        'start_in' => 'nullable',
        'author' => 'nullable|string|max:255',
        'status' => 'required|boolean',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}

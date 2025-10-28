<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public $table = 'notifications';

    public $fillable = [
        'type',
        'name',
        'phone',
        'product_id',
        'store_id',
        'comment',
        'notification_status',
        'notification_user_id',
        'client_ip',
        'client_user_agent'
    ];

    protected $casts = [
        'type' => 'string',
        'name' => 'string',
        'phone' => 'string',
        'comment' => 'string',
        'client_ip' => 'string',
        'client_user_agent' => 'string'
    ];

    public static array $rules = [
        'type' => 'required|string|max:255',
        'name' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:255',
        'product_id' => 'nullable',
        'comment' => 'nullable|string|max:65535',
        'notification_status' => 'nullable',
        'notification_user_id' => 'nullable',
        'store_id' =>'nullable',
        'client_ip' => 'required|string|max:255',
        'client_user_agent' => 'required|string|max:255',
        'created_at' => 'required',
        'updated_at' => 'nullable'
    ];

}

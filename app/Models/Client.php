<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public $table = 'clients';

    public $fillable = [
        'activation',
        'photo',
        'surname',
        'name',
        'birthday',
        'email',
        'phone',
        'password',
        'user_agent',
        'location_id',
        'address',
        'remember_token',
        'temporary_code',
        'hash',
        'viber_id',
        'app_token',
        'verification_phone_code',
        'verification_email_code',
        'verified_phone',
        'verified_email',
        'up_to_1c',
        'updated_at_1c'
    ];

    protected $casts = [
        'activation' => 'boolean',
        'photo' => 'string',
        'surname' => 'string',
        'name' => 'string',
        'birthday' => 'date',
        'email' => 'string',
        'phone' => 'string',
        'password' => 'string',
        'user_agent' => 'string',
        'address' => 'string',
        'remember_token' => 'string',
        'temporary_code' => 'string',
        'hash' => 'string',
        'viber_id' => 'string',
        'app_token' => 'string',
        'verification_phone_code' => 'string',
        'verification_email_code' => 'string',
        'verified_phone' => 'boolean',
        'verified_email' => 'boolean',
        'up_to_1c' => 'boolean',
        'updated_at_1c' => 'datetime'
    ];

    public static array $rules = [
        'activation' => 'required|boolean',
        'photo' => 'nullable|string|max:255',
        'surname' => 'nullable|string|max:255',
        'name' => 'required|string|max:255',
        'birthday' => 'nullable',
        'email' => 'nullable|string|max:255',
        'phone' => 'required|string|max:255',
        'password' => 'nullable|string|max:255',
        'user_agent' => 'required|string|max:65535',
        'location_id' => 'nullable',
        'address' => 'nullable|string|max:255',
        'remember_token' => 'nullable|string|max:100',
        'temporary_code' => 'nullable|string|max:65535',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'hash' => 'nullable|string|max:255',
        'viber_id' => 'nullable|string|max:255',
        'app_token' => 'nullable|string|max:255',
        'verification_phone_code' => 'nullable|string|max:255',
        'verification_email_code' => 'nullable|string|max:255',
        'verified_phone' => 'required|boolean',
        'verified_email' => 'required|boolean',
        'up_to_1c' => 'required|boolean',
        'updated_at_1c' => 'nullable'
    ];

    public function appClientSettings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\AppClientSetting::class, 'client_id');
    }

    public function appTasks(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\AppTask::class, 'app_client_task_rewards');
    }

    public function appTask1s(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\AppTask::class, 'app_client_tasks');
    }

    public function appNotifications(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\AppNotification::class, 'client_id');
    }

    public function appReferrals(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\AppReferral::class, 'client_id');
    }

    public function appReferral2s(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\AppReferral::class, 'invited_id');
    }

    public function appSocialData(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\AppSocialDatum::class, 'client_id');
    }

    public function carts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Cart::class, 'client_id');
    }

    public function clientBonusPreviousHistories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\ClientBonusPreviousHistory::class, 'client_id');
    }
}

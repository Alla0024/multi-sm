<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonusProgram extends Model
{
    public $table = 'bonus_programs';

    public $fillable = [
        'hash',
        'type',
        'usage_percentage',
        'min_total_price',
        'color',
        'started_at',
        'finished_at',
        'priority'
    ];

    protected $casts = [
        'hash' => 'string',
        'type' => 'string',
        'color' => 'string',
        'started_at' => 'datetime',
        'finished_at' => 'datetime'
    ];

    public static array $rules = [
        'hash' => 'nullable|string|max:255',
        'type' => 'required|string|max:255',
        'usage_percentage' => 'nullable',
        'min_total_price' => 'nullable',
        'color' => 'nullable|string|max:255',
        'started_at' => 'nullable',
        'finished_at' => 'nullable',
        'priority' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function description()
    {
        return $this->hasOne(BonusProgramDescription::class, 'bonus_program_id')
            ->where('language_id', config('settings.locale.default_language_id'));

    }

    public function descriptions()
    {
        return $this->hasMany(BonusProgramDescription::class, 'bonus_program_id');
    }

    public function seoPath()
    {
        return $this->hasOne(FirstPathQuery::class, 'type_id')->where('type', 'bonus_program');
    }

    public function stores()
    {
        return $this->belongsToMany(Store::class, BonusProgramToStore::class);
    }

    public function languages(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Language::class, 'bonus_program_descriptions');
    }

    public function paymentMethods()
    {
        return $this->belongsToMany(PaymentMethod::class, BonusProgramToPaymentMethod::class, 'payment_id', 'bonus_program_id');
    }

    public function segments()
    {
        return $this->belongsToMany(Segment::class, BonusProgramToSegment::class);
    }

    public function clientBonusPreviousHistories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\ClientBonusPreviousHistory::class, 'bonus_program_id');
    }

    public function saleGroups(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\SaleGroup::class, 'sale_group_to_bonus_programs');
    }

    public static function getBonusPrograms()
    {
        return self::with('descriptions')->get();
    }
}

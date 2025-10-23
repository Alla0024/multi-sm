<?php

namespace App\Repositories;

use App\Models\Currency;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Cache;

class CurrencyRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'code',
        'title',
        'symbol',
        'rate',
        'status'
    ];

    protected array $additionalFields = [
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function getAdditionalFields(): array
    {
        return $this->additionalFields;
    }

    public function model(): string
    {
        return Currency::class;
    }

    public function getCachedCurrencies()
    {
        return Cache::remember('currencies', config('settings.time_cache_admin'), function () {
            return $this->all();
        });
    }
}

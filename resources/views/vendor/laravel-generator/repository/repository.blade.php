@php
    echo "<?php".PHP_EOL;
@endphp

namespace {{ $config->namespaces->repository }};

use {{ $config->namespaces->model }}\{{ $config->modelNames->name }};
use {{ $config->namespaces->app }}\Repositories\BaseRepository;

class {{ $config->modelNames->name }}Repository extends BaseRepository
{
    protected $fieldSearchable = [
        {!! $fieldSearchable !!}
    ];

    protected $additionalFields = [
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
        return {{ $config->modelNames->name }}::class;
    }
}

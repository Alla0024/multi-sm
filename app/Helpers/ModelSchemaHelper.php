<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ModelSchemaHelper
{
    public static function buildSchemaFromModelNames(array $modelClasses, array|null $order = null): array
    {
        $allFields = [];

        foreach ($modelClasses as $index => $modelClass) {
            $repositoryClass = str_replace('Models', 'Repositories', $modelClass) . 'Repository';

            if (!class_exists($repositoryClass)) {
                continue;
            }

            $repo = app($repositoryClass);

            if (!method_exists($repo, 'model') || !method_exists($repo, 'getFieldsSearchable')) {
                continue;
            }

            $searchable = $repo->getFieldsSearchable();

            $additional = method_exists($repo, 'getAdditionalFields')
                ? $repo->getAdditionalFields()
                : [];

            $fields = self::buildSchema($modelClass, $searchable, $additional);

            $allFields = array_merge($allFields, $fields);
        }

        if (is_array($order)) {
            $sorted = [];
            foreach ($order as $key) {
                if (array_key_exists($key, $allFields)) {
                    $sorted[$key] = $allFields[$key];
                }
            }

            $allFields = $sorted;
        }

        return $allFields;
    }

    public static function buildSchema(string $modelClass, array $searchable = [], array $additional = []): array
    {
        $model = new $modelClass;
        $table = $model->getTable();
        $columns = Schema::getColumnListing($table);
        $fillable = $model->getFillable();
        $primaryKey = $model->getKeyName();

        $primaryFields = collect($columns)->mapWithKeys(function ($column, $index) use ($searchable, $fillable, $primaryKey) {
            $isSearchable = in_array($column, $searchable);
            return [
                $column => [
                    'dbType' => self::dbTypeFromName($column),
                    'htmlType' => self::htmlTypeFromName($column),
                    'validations' => self::validation($column),
                    'searchable' => $isSearchable,
                    'fillable' => in_array($column, $fillable),
                    'primary' => $column === $primaryKey,
                    'inForm' => true,
                    'inIndex' => true,
                    'inView' => true,
                    "inTable" => $isSearchable,
                    "inTab" => 'main',
                ],
            ];
        })->toArray();

        $additionalFields = [];

        foreach ($additional as $key => $value) {
            $rules = [];

            if (is_int($key)) {
                $field = $value;
            } else {
                $field = $key;
                $rules = $value;
            }

            $isSearchable = in_array($field, $searchable);

            $additionalFields[$field] = [
                'dbType' => $rules['dbType'] ?? self::dbTypeFromName($field),
                'htmlType' => $rules['htmlType'] ?? self::htmlTypeFromName($field),
                'validations' => $rules['validations'] ?? self::validation($field),
                'searchable' => $rules['searchable'] ?? $isSearchable,
                'fillable' => $rules['fillable'] ?? in_array($field, $fillable),
                'primary' => $rules['primary'] ?? $field === $primaryKey,
                'inForm' => $rules['inForm'] ?? true,
                'inIndex' => $rules['inIndex'] ?? true,
                'inView' => $rules['inView'] ?? true,
                "inTable" => $rules['inTable'] ?? $isSearchable,
                "inTab" => $rules['inTab'] ?? 'main',
            ];
        }

        return array_merge($primaryFields, $additionalFields);
    }

    private static function dbTypeFromName(string $name): string
    {
        return match (true) {
            Str::endsWith($name, '_id'), Str::contains($name, 'status') => 'integer',
            Str::contains($name, 'date'), Str::contains($name, '_at') => 'timestamp',
            default => 'string',
        };
    }

    private static function htmlTypeFromName(string $name): string
    {
        return match (true) {
            Str::contains($name, 'password') => 'password',
            Str::contains($name, 'email') => 'email',
            Str::contains($name, 'status') => 'checkbox',
            Str::contains($name, 'order') => 'number',
            Str::contains($name, 'descriptions') => 'textarea',
            Str::contains($name, 'date'), Str::contains($name, 'at') => 'hidden',
            default => 'text',
        };
    }

    private static function validation(string $name): string
    {
        return match (true) {
            $name === 'id', Str::contains($name, 'created_at'), Str::contains($name, 'updated_at') => '',
            Str::contains($name, 'status') => 'required',
            default => 'nullable|max:255',
        };
    }
}

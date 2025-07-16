<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ModelSchemaHelper
{
    public static function buildSchemaFromModelNames(array $modelClasses): array
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

            $fields = self::buildSchema($modelClass, $searchable);

            $allFields = array_merge($allFields, $fields);
        }

        return $allFields;
    }

    public static function buildSchema(string $modelClass, array $searchable = []): array
    {
        $model = new $modelClass;
        $table = $model->getTable();
        $columns = Schema::getColumnListing($table);
        $fillable = $model->getFillable();
        $primaryKey = $model->getKeyName();

        return collect($columns)->map(function ($column) use ($searchable, $fillable, $primaryKey) {
            return [
                'name' => $column,
                'dbType' => self::dbTypeFromName($column),
                'htmlType' => self::htmlTypeFromName($column),
                'validations' => self::validation($column),
                'searchable' => in_array($column, $searchable),
                'fillable' => in_array($column, $fillable),
                'primary' => $column === $primaryKey,
                'inForm' => true,
                'inIndex' => true,
                'inView' => true,
                "inTable" => false,
                "inTab" => 'main',
            ];
        })->toArray();
    }

    private static function dbTypeFromName(string $name): string
    {
        return match (true) {
            Str::endsWith($name, '_id'), Str::contains($name, 'status') => 'integer',
            Str::contains($name, 'date'), Str::contains($name, 'at') => 'timestamp',
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

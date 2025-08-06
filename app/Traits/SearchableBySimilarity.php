<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait SearchableBySimilarity
{
    /**
     * Scope: search across multiple fields with similarity-based sorting.
     *
     * @param  Builder  $query
     * @param  array|string  $fields  A field or an array of fields to search in
     * @param  string  $term  The search keyword (substring to match)
     * @return Builder
     */
    public function scopeSearchSimilarity(Builder $query, $fields, string $term): Builder
    {
        $fields = is_array($fields) ? $fields : [$fields];
        $driver = $query->getModel()->getConnection()->getDriverName();
        $lowerTerm = mb_strtolower($term, 'UTF-8');

        $query->where(function (Builder $q) use ($fields, $driver, $term, $lowerTerm) {
            foreach ($fields as $field) {
                if ($driver === 'pgsql') {
                    $q->orWhere($field, 'ILIKE', "%{$term}%");
                } else {
                    $q->orWhereRaw("LOWER({$field}) LIKE ?", ["%{$lowerTerm}%"]);
                }
            }
        });

        $positionExpr = [];
        $bindings = [];

        foreach ($fields as $field) {
            $positionExpr[] = "COALESCE(NULLIF(POSITION(? IN LOWER({$field})), 0), 999999)";
            $bindings[] = $lowerTerm;
        }

        $rawOrder = 'LEAST(' . implode(', ', $positionExpr) . ')';
        $query->orderByRaw($rawOrder, $bindings);

        return $query;
    }
}

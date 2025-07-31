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
        $upperTerm = mb_strtoupper($term, 'UTF8');

        $query->where(function ($q) use ($fields, $upperTerm) {
            foreach ($fields as $field) {
                $q->orWhereRaw("UPPER($field) LIKE ?", ["%{$upperTerm}%"]);
            }
        });

        $positionExpr = [];
        $bindings = [];
        foreach ($fields as $field) {
            $positionExpr[] = "COALESCE(NULLIF(POSITION(? IN UPPER($field)), 0), 999999)";
            $bindings[] = $upperTerm;
        }

        $least = implode(', ', $positionExpr);
        $query->orderByRaw("LEAST($least)", $bindings);

        return $query;
    }
}

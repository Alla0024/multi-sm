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
        $lowerTerm = mb_strtolower($term, 'UTF-8');

        $query->where(function (Builder $q) use ($fields, $lowerTerm) {
            foreach ($fields as $field) {
                $q->orWhereRaw("LOWER({$field}) LIKE ?", ["%{$lowerTerm}%"]);
            }
        });

        $query->orderByRaw(
            "CASE WHEN LOWER({$fields[0]}) LIKE ? THEN 1 ELSE 2 END",
            ["{$lowerTerm}%"]
        );

        return $query;
    }
}

<?php

namespace App\Traits;

use App\Repositories\FirstPathQueryRepository;
use Illuminate\Validation\Validator;

trait AdditionalRequestRules
{
    public function getFirstPathQueryRules(): array
    {
        return [
            'path' => 'required|string',
        ];
    }

    public function applyFirstPathQueryValidator(Validator $validator, string $path, $exclude_id = null, $item_type = null): void
    {
        $validator->after(function ($validator) use ($path, $exclude_id ,$item_type) {
            $exists = app(FirstPathQueryRepository::class)->isThisPathExists($path, $exclude_id, $item_type);

            if ($exists) {
                $validator->errors()->add('path', __('common.error_path_already_taken'));
            }
        });
    }
}

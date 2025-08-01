<?php

namespace App\Traits;

use App\Repositories\FirstPathQueryRepository;
use Illuminate\Validation\Validator;

trait PathQueryRules
{
    public function getFirstPathQueryRules(): array
    {
        return [
            'path' => 'required|string',
        ];
    }

    public function applyFirstPathQueryValidator(Validator $validator, string $path): void
    {
        $validator->after(function ($validator) use ($path) {
            $exists = app(FirstPathQueryRepository::class)->isThisPathExists($path);

            if ($exists) {
                $validator->errors()->add('path', __('common.error_path_already_taken'));
            }
        });
    }
}

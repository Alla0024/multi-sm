<?php

namespace App\Http\Requests;

use App\Models\Option;
use App\Repositories\OptionRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CreateOptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(
            Option::$rules,
            [
                'path' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        $exists = app(OptionRepository::class)->isOptionWithProvidedPathExists($value);

                        if ($exists) {
                            $fail(__('common.error_path_already_taken'));
                        }
                    }
                ]
            ]
        );
    }
}

<?php

namespace App\Http\Requests;

use App\Models\Option;
use App\Repositories\OptionRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateOptionRequest extends FormRequest
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
        $id = $this->route()->parameter('option');

        return array_merge(Option::$rules, [
            'path' => [
                function ($attribute, $value, $fail) use ($id) {
                    if (isset($value) && app(OptionRepository::class)->isOptionWithProvidedPathExists($value, $id)) {
                        $fail(__('common.error_path_already_taken'));
                    }
                },
            ],
        ]);
    }
}

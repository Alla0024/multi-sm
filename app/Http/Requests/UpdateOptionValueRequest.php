<?php

namespace App\Http\Requests;

use App\Models\OptionValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateOptionValueRequest extends FormRequest
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
//        $rules = OptionValue::$rules;

        return [];
    }

    public function withValidator(Validator $validator) {
    }
}

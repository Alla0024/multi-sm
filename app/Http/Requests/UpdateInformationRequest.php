<?php

namespace App\Http\Requests;

use App\Models\Information;
use App\Repositories\FirstPathQueryRepository;
use App\Traits\AdditionalRequestRules;
use Illuminate\Foundation\Http\FormRequest;

class UpdateInformationRequest extends FormRequest
{
    use AdditionalRequestRules;
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
        $rules = array_keys(
            $this->getFirstPathQueryRules(),
            Information::$rules
        );

        return $rules;
    }

    public function withValidator($validator) {
        $this->applyFirstPathQueryValidator($validator, $this->input('path'), $this->input('id'));
    }
}

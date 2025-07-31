<?php

namespace App\Http\Requests;

use App\Models\Information;
use App\Repositories\FirstPathQueryRepository;
use App\Traits\PathQueryRules;
use Illuminate\Foundation\Http\FormRequest;

class CreateInformationRequest extends FormRequest
{
    use PathQueryRules;
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
            $this->getFirstPathQueryRules(),
            Information::$rules
        );
    }

    public function withValidator($validator) {
        $this->applyFirstPathQueryValidator($validator, $this->input('path'));
    }
}

<?php

namespace App\Http\Requests;

use App\Models\News;
use App\Repositories\FirstPathQueryRepository;
use App\Traits\AdditionalRequestRules;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsRequest extends FormRequest
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
            News::$rules
        );

        return $rules;
    }

    public function withValidator($validator) {
        $id = $this->route()->parameter('news');
        $this->applyFirstPathQueryValidator($validator, $this->input('path'), $id, 'news');
    }
}

<?php

namespace App\Http\Requests;

use App\Models\News;
use App\Repositories\OptionRepository;
use App\Traits\AdditionalRequestRules;
use Illuminate\Foundation\Http\FormRequest;

class CreateNewsRequest extends FormRequest
{
    use AdditionalRequestRules;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return array_merge(
            $this->getFirstPathQueryRules(),
            News::$rules,
        );
    }

    public function withValidator($validator) {
        $this->applyFirstPathQueryValidator($validator, $this->input('path'));
    }
}

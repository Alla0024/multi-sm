<?php

namespace App\Http\Requests;

use App\Models\IndividualEntrepreneur;
use Illuminate\Foundation\Http\FormRequest;

class UpdateIndividualEntrepreneurRequest extends FormRequest
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
        $rules = IndividualEntrepreneur::$rules;
        
        return $rules;
    }
}

<?php

namespace App\Http\Requests;

use App\Models\AttributeWord;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAttributeWordRequest extends FormRequest
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
        $rules = AttributeWord::$rules;
        
        return $rules;
    }
}

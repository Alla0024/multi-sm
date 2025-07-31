<?php

namespace App\Http\Requests;

use App\Models\Information;
use App\Repositories\FirstPathQueryRepository;
use Illuminate\Foundation\Http\FormRequest;

class CreateInformationRequest extends FormRequest
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
        return Information::$rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $path = $this->input('path');

            $exists = app(FirstPathQueryRepository::class)->isThisPathExists($path, null);

            if ($exists) {
                $validator->errors()->add('path', 'This path is already taken.');
            }
        });
    }
}

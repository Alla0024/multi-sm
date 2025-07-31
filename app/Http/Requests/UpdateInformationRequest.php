<?php

namespace App\Http\Requests;

use App\Models\Information;
use App\Repositories\FirstPathQueryRepository;
use Illuminate\Foundation\Http\FormRequest;

class UpdateInformationRequest extends FormRequest
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
        $rules = Information::$rules;

        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $path = $this->input('path');
            $id = $this->route('information');

            $exists = app(FirstPathQueryRepository::class)->isThisPathExists($path, $id);

            if ($exists) {
                $validator->errors()->add('path', 'This path is already taken.');
            }
        });
    }
}

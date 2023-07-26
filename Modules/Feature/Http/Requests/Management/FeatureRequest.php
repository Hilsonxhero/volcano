<?php

namespace Modules\Feature\Http\Requests\Management;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Enum;
use Modules\Feature\Enums\FeatureStatus;

class FeatureRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (request()->getMethod() == "PUT") {
            return [
                'title' => ['required'],
                'description' => ['required'],
                'status' => ['required', new Enum(FeatureStatus::class)],
                'media' => ['nullable'],
            ];
        }

        return [
            'title' => ['required'],
            'description' => ['required'],
            'status' => ['required', new Enum(FeatureStatus::class)],
            'cover' => ['required'],
            'icon' => ['required'],
        ];
    }


    public function failedValidation($validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ], 422));
    }
}

<?php

namespace Modules\Service\Http\Requests\Management;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Enum;
use Modules\Service\Enums\ServiceStatus;

class ServiceRequest extends FormRequest
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
                'status' => ['required', new Enum(ServiceStatus::class)],
                'media' => ['nullable'],
            ];
        }

        return [
            'title' => ['required'],
            'description' => ['required'],
            'status' => ['required', new Enum(ServiceStatus::class)],
            'media' => ['required'],
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

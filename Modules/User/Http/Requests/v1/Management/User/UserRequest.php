<?php

namespace Modules\User\Http\Requests\v1\Management\User;

use Illuminate\Validation\Rule;
use Modules\User\Enums\UserStatus;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
                'username' => ['required'],
                'email' => ['required', Rule::unique('users', 'email')->ignore(request()->id)],
                'phone' => ['nullable', Rule::unique('users', 'phone')->ignore(request()->id)],
                'role' => ['required', 'exists:roles,id'],
                'status' => ['required', new Enum(UserStatus::class)],
            ];
        }

        return [
            'username' => ['required'],
            'email' => ['required', Rule::unique('users', 'email')],
            'phone' => ['required', Rule::unique('users', 'phone')],
            'role' => ['required', 'exists:roles,id'],
            'status' => ['required', new Enum(UserStatus::class)],
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

<?php

namespace Modules\RolePermissions\Http\Requests\v1\Management\Role;

use Illuminate\Validation\Rule;
use Modules\User\Enums\UserStatus;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RoleRequest extends FormRequest
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
                'name' => ['required', Rule::unique('roles', 'name')->ignore(request()->id)],
                'parent_id' => ['required', Rule::exists('roles', 'id')],
            ];
        }

        return [
            'title' => ['required'],
            'name' => ['required', Rule::unique('roles', 'name')],
            'parent_id' => ['required', Rule::exists('roles', 'id')],
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

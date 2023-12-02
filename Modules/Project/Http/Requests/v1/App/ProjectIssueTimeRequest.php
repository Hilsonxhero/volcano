<?php

namespace Modules\Project\Http\Requests\v1\App;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ProjectIssueTimeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (request()->getMethod() == "PUT" || request()->getMethod() == "PATCH") {
            return [
                'project_time_category_id' => ['required'],
                'description' => ['required'],
                'hours' => ['required'],
            ];
        }

        return [
            'project_time_category_id' => ['required'],
            'description' => ['required'],
            'hours' => ['required'],
        ];
    }

    public function failedValidation($validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => trans('response.responses.422'),
            'data'      => $validator->errors()
        ], 422));
    }
}

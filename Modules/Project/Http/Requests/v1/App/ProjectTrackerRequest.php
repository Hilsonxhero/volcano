<?php

namespace Modules\Project\Http\Requests\v1\App;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ProjectTrackerRequest extends FormRequest
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
                'title' => ['required'],
                'status' => ['required'],
                'description' => ['required'],
                'project_id' => ['required', Rule::exists('projects', 'id')],
            ];
        }

        return [
            'title' => ['required'],
            'status' => ['required'],
            'description' => ['required'],
            'project_id' => ['required', Rule::exists('projects', 'id')],
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

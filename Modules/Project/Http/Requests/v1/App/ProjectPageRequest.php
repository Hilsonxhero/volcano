<?php

namespace Modules\Project\Http\Requests\v1\App;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ProjectPageRequest extends FormRequest
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
                'content' => ['nullable'],
                'project_id' => ['nullable', Rule::exists('projects', 'id')],
                'parent_id' => ['nullable', Rule::exists('project_pages', 'id')],
            ];
        }

        return [
            'title' => ['required'],
            'content' => ['nullable'],
            'project_id' => ['required', Rule::exists('projects', 'id')],
            'parent_id' => ['nullable', Rule::exists('project_pages', 'id')],
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

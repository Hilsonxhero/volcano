<?php

namespace Modules\Project\Http\Requests\v1\App;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ProjectIssueRequest extends FormRequest
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
                'description' => ['required'],
                'note' => ['nullable'],
                'project_id' => ['required', Rule::exists('projects', 'id')],
                'project_tracker_id' => ['required', Rule::exists('project_trackers', 'id')],
                'project_issue_status_id' => ['required', Rule::exists('project_issue_statuses', 'id')],
                'assigned_to_id' => ['required', Rule::exists('users', 'id')],
                'project_priority_id' => ['required', Rule::exists('project_priorities', 'id')],
                'start_date' => ['required'],
                'end_date' => ['nullable'],
                'estimated_hours' => ['nullable'],
                'done_ratio' => ['required']
            ];
        }

        return [
            'title' => ['required'],
            'description' => ['required'],
            'note' => ['nullable'],
            'project_id' => ['required', Rule::exists('projects', 'id')],
            'project_tracker_id' => ['required', Rule::exists('project_trackers', 'id')],
            'project_issue_status_id' => ['required', Rule::exists('project_issue_statuses', 'id')],
            'assigned_to_id' => ['required', Rule::exists('users', 'id')],
            'project_priority_id' => ['required', Rule::exists('project_priorities', 'id')],
            'start_date' => ['required'],
            'end_date' => ['nullable'],
            'estimated_hours' => ['nullable'],
            'done_ratio' => ['required']
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

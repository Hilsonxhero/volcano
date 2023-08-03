<?php

namespace Modules\Contact\Http\Controllers\v1\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Contact\Enums\ContactMessageStatus;
use Modules\Contact\Http\Requests\Web\ContactMessageRequest;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function store(ContactMessageRequest $request)
    {
        $data = array(
            'name' => $request->name,
            'email' => $request->email,
            'content' => $request->content,
            'status' => ContactMessageStatus::PENDING->value,
        );
        $message = contactMessageRepo()->create($data);
        ApiService::_success(trans('response.responses.200'));
    }
}

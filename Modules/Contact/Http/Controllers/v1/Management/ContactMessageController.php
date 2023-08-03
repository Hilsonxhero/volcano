<?php

namespace Modules\Contact\Http\Controllers\v1\Management;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Modules\Contact\Http\Requests\Management\ContactMessageRequest;
use Modules\Contact\Transformers\Management\ContactMessageResource;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $contact_messages = contactMessageRepo()->all();
        $contact_messages_collection = ContactMessageResource::collection($contact_messages);
        ApiService::_success(
            array(
                'messages' => $contact_messages_collection,
                'pager' => array(
                    'pages' => $contact_messages_collection->lastPage(),
                    'total' => $contact_messages_collection->total(),
                    'current_page' => $contact_messages_collection->currentPage(),
                    'per_page' => $contact_messages_collection->perPage(),
                )
            )
        );
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $message = contactMessageRepo()->show($id);
        return new ContactMessageResource($message);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(ContactMessageRequest $request, $id)
    {
        $data = array(
            'status' => $request->status,
            'answer' => $request->answer,
        );
        $message = contactMessageRepo()->update($id, $data);
        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $message = contactMessageRepo()->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}

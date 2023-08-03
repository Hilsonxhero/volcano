<?php

namespace Modules\Contact\Http\Controllers\v1\Management;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;
use Illuminate\Support\Facades\Notification;
use Modules\Contact\Enums\ContactMessageStatus;
use Modules\Contact\Transformers\Management\ContactMessageResource;
use Modules\Contact\Notifications\App\ContactMessageAnswerNotification;

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
    public function update(Request $request, $id)
    {
        $data = array(
            'status' => ContactMessageStatus::ANSWER->value,
        );
        $message = contactMessageRepo()->update($id, $data);
        $mail_data = array(
            'answer' => $request->answer,
            'email' => $message->email,
            'content' => $message->content,
        );
        Notification::route('mail', null)->notify(new ContactMessageAnswerNotification($mail_data));
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

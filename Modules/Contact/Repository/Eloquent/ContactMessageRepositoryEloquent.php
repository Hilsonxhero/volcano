<?php

namespace Modules\Contact\Repository\Eloquent;

use Modules\Contact\Entities\ContactMessage;
use Modules\Contact\Repository\Contracts\ContactMessageRepository;

class ContactMessageRepositoryEloquent implements ContactMessageRepository
{
    public function all()
    {
        $query = ContactMessage::query()->orderBy('created_at', 'desc');
        $query->when(request()->has('q'), function ($query) {
            $searchTerm = "%" . request()->q . "%";
            $query->where(function ($query) use ($searchTerm) {
                $query->where('email', 'LIKE', $searchTerm)
                    ->orWhere('name', 'LIKE', $searchTerm);
            });
        });
        return $query->paginate();
    }
    public function create($data)
    {
        $message =  ContactMessage::query()->create($data);
        return $message;
    }
    public function update($id, $data)
    {
        $message = $this->find($id);
        $message->update($data);
        return $message;
    }
    public function show($id)
    {
        $message = $this->find($id);
        return $message;
    }
    public function find($id)
    {
        return ContactMessage::query()->where('id', $id)->first();
    }
    public function delete($id)
    {
        $message = $this->find($id);
        $message->delete();
    }
}

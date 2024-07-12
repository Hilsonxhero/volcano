<x-mail::message>

# {{__('common.board.invite.title', ['name' => $data['name']])}}

{{__('common.board.invite.content', ['name' => $data['name'],'project' => $data['board']['title']])}}

<x-mail::button :url="$data['url']">
{{__('common.board.invite.join')}}
</x-mail::button>

<br>
{{ config('app.name') }}
</x-mail::message>

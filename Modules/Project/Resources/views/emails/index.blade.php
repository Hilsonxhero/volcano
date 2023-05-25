<x-mail::message>

# {{__('common.invite.title', ['name' => $data['name']])}}
 
{{-- {{$data['content']}} --}}

{{-- Here's what Blocker and your team are using to work seamlessly and accomplish more, together: --}}
{{__('common.invite.content', ['name' => $data['name'],'project' => $data['project']['title']])}}

<x-mail::button :url="$data['url']">
{{__('common.invite.join')}}
</x-mail::button>
 
Cheers,<br>
{{ config('app.name') }}
</x-mail::message>
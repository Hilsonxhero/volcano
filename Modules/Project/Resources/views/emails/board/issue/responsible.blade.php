<x-mail::message>
مسئله {{$data->id}} توسط  {{$data->creator->username}} افزوده شد.
<hr />

# <a href="{{front_path("portal/projects/{$data->project->id}/issues/{$data->id}")}}">{{$data->tracker->title}} #{{$data->id}}: {{$data->title}}</a>

<br>

<ul>
    <li>
        <span>
            نویسنده:
        </span>
        <span>
           {{$data->creator->username}}
        </span>
    </li>
    <li>
        <span>
            وضعیت:
        </span>
        <span>
           {{$data->issue_status->title}}
        </span>
    </li>
    <li>
        <span>
            اولویت:
        </span>
        <span>
            {{$data->project_priority->title}}
        </span>
    </li>
    <li>
        <span>
            مسئول:
        </span>
        <span>
            {{$data->assigned->username}}
        </span>
    </li>
    <li>
        <span>
            تاریخ آغاز:
        </span>
        <span>
            {{formatGregorian($data->start_date)}}
        </span>
    </li>
</ul>

<br>

<section>
    {!! $data->description !!}
</section>

<br>
<hr />
<br>
{{ config('app.name') }}
</x-mail::message>

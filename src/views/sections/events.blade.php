@if(count($events))
<table class="table table-hover">
    <thead>
    <th>Fecha</th>
    <th>Usuario</th>
    <th>Evento</th>
    <th>Data Old</th>
    <th>Data New</th>
</thead>
<tbody>
    @foreach($events as $event)
    <tr>
        <td>
            <div title="{{$event['created_at']}}">{{$event['created_at']}}</div>
        </td>
        <td>
            <div title="{{$event['user_id']}}">{{$event->user->name}}</div>
        </td>
        <td>
            <div title="{{$event['event']}}">{{$event['event']}}</div>
        </td>
        <td>
            @include('presentations.prettyjson', ['json' => $event['old_values']])
        </td>
        <td>
            @include('presentations.prettyjson', ['json' => $event['new_values']])
        </td>
    </tr>
    @endforeach
</tbody>
</table>
{{$events->fragment('events')->render()}}
@endif
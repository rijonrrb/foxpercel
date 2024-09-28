@foreach ($rows as $key => $row)
    <tr style="background: {{$row->level?->color}} !important;">
        <td>{{$row->level?->defcon_level}}</td>
        <td>{!! nl2br(e($row->description)) !!}</td>
        <td>{!! nl2br(e($row->action)) !!}</td>
    </tr>
@endforeach

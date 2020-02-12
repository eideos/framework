<table id="{{class_basename($model)}}" class="table table-striped table-bordered" style="width:100%">
    <thead style="background-color: var(--secondary);">
        <tr>
            @foreach ($listfields as $listfield)
            @if(is_array($listfield) && isset($listfield['fields']))
            @foreach ($listfield['fields'] as $field)
            @if(!isset($field->isvisible) || $field->isvisible)
            <th>{{$field->getLabel()}}</th>
            @endif
            @endforeach
            @else
            @if(!isset($listfield->isvisible) || $listfield->isvisible)
            <th>{{$listfield->getLabel()}}</th>
            @endif
            @endif
            @endforeach
            @if (isset($data["actions"]) && count($data["actions"]))
            <th>Acciones</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $row)
        <tr>
            @foreach ($listfields as $listfield)
            @if(is_array($listfield) && isset($listfield['fields']))
            @foreach ($listfield['fields'] as $field)
            @if(!isset($field->isvisible) || $field->isvisible)
            <td>
                {{$row[$field->getName()]->getHelperValue()}}
            </td>
            @endif            
            @endforeach
            @else
            @if(!isset($listfield->isvisible) || $listfield->isvisible)            
            <td>
                {{$row[$listfield->getName()]->getHelperValue()}}
            </td>
            @endif
            @endif
            @endforeach
            @if (isset($data["actions"]) && count($data["actions"]))
            <td>
                @foreach ($data['actions'] as $action)
                @if ((!isset($action["global"]) || !$action["global"]) && is_authorized($action['controller'] ?? $controller,$action["action"]) && (!isset($action["displayFunction"]) || !function_exists($action["displayFunction"]) || $action["displayFunction"]($row)))
                @if (!isset($action["post"]) || !$action["post"])
                <a href="{{fmw_action($action['controller'] ?? $controller, $action['action'], $row['__id'])}}" title="{{$action['label']}}" class="btn btn-circle btn-sm {{$action['class']??'btn-secondary'}} float-left mr-1" {{(isset($action['blank']) && $action['blank']=="true" ? 'target="blank"' : '')}}>
                    <i class="fa fa-{{$action['icon']}}"></i>
                </a>
                @else
                <form action="{{fmw_action($action['controller'] ?? $controller, $action['action'], $row['__id'])}}" method="post">
                    @csrf
                    <input name="_method" type="hidden" value="{{$action['method']??'DELETE'}}">
                    <button type="submit" class="btn btn-circle btn-sm {{$action['class']??'btn-danger'}} float-left mr-1" title="{{$action['label']}}">
                        <i class="fa fa-{{$action['icon']??'trash'}}"></i>
                    </button>
                </form>
                @endif
                @endif
                @endforeach
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $("#{{class_basename($model)}}").DataTable(
            {!!(json_encode($datatable['params']) ?? [])!!}
        );
    });
</script>
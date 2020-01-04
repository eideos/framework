<table data-model="{{class_basename($model)}}" class="table table-striped">
    <thead>
        <tr>
            @foreach ($listfields as $listfield)
            @if(is_array($listfield) && isset($listfield['fields']))
            <th>{{$listfield['label']??""}}</th>
            @else
            <th>{{$listfield->getLabel()}}</th>
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
            <td>
                @foreach ($listfield['fields'] as $field)
                @if (count($listfield['fields']) > 1 && !is_null($row[$field->getName()]->getViewVars()['value']))
                <small class="text-muted">{{$field->getLabel()}}</small>
                @endif
                @include($row[$field->getName()]->getViewFieldPath(), $row[$field->getName()]->getViewVars())
                @endforeach
            </td>
            @else
            <td>
                @include($row[$listfield->getName()]->getViewFieldPath(), $row[$listfield->getName()]->getViewVars())
            </td>
            @endif
            @endforeach
            @if (isset($data["actions"]) && count($data["actions"]))
            <td>
                @foreach ($data['actions'] as $action)
                @if ((!isset($action["global"]) || !$action["global"]) && is_authorized($action['controller'] ?? $controller,$action["action"]) && (!isset($action["displayFunction"]) || !function_exists($action["displayFunction"]) || $action["displayFunction"]($row)))
                @if (!isset($action["post"]) || !$action["post"])
                <a href="{{fmw_action($action['controller'] ?? $controller, $action['action'], $row['__id'])}}" data-toggle="tooltip" data-placement="top" title="{{$action['label']}}" class="btn btn-circle btn-sm {{$action['class']??'btn-secondary'}} float-left mr-1" {{(isset($action['blank']) && $action['blank']=="true" ? 'target="blank"' : '')}}>
                    <i class="fa fa-{{$action['icon']}}"></i>
                </a>
                @else
                <form action="{{fmw_action($action['controller'] ?? $controller, $action['action'], $row['__id'])}}" method="post">
                    @csrf
                    <input name="_method" type="hidden" value="{{$action['method']??'DELETE'}}">
                    <button type="submit" class="btn btn-circle btn-sm {{$action['class']??'btn-danger'}} float-left mr-1" data-toggle="tooltip" data-placement="top" title="{{$action['label']}}">
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
{{ $paginateRows->appends($query)->links() }}

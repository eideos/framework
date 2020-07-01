<table id="{{class_basename($model)}}" class="table table-striped table-bordered table-condensed display compact nowrap" style="width:100%">
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
            <th>Acciones de {{str_plural(class_basename($model))}}</th>
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
            <td class="dt-tbody-td {{isset($field->isNumeric) && $field->isNumeric  ? 'td-numeric' : 'td-text'}}">
                {!! $row[$field->getName()]->getHelperValue() !!}
            </td>
            @endif            
            @endforeach
            @else
            @if(!isset($listfield->isvisible) || $listfield->isvisible)            
            <td class="dt-tbody-td {{isset($listfield->isNumeric) && $listfield->isNumeric  ? 'td-numeric' : 'td-text'}}">
            {!! $row[$listfield->getName()]->getHelperValue() !!}
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
    @if(!isset($datatable['params']['footer']) || $datatable['params']['footer'])
    <tfoot style="background-color: var(--secondary);">
        <tr>
            @foreach ($listfields as $listfield)
            @if(is_array($listfield) && isset($listfield['fields']))
            @foreach ($listfield['fields'] as $field)
            @if(!isset($field->isvisible) || $field->isvisible)
            <th id='tfoot_{{str_replace(".", "_", $field->name)}}'></th>
            @endif
            @endforeach
            @else
            @if(!isset($listfield->isvisible) || $listfield->isvisible)
            <th id='tfoot_{{str_replace(".", "_", $listfield->name)}}'></th>
            @endif
            @endif
            @endforeach
            @if (isset($data["actions"]) && count($data["actions"]))
            <th id='tfoot_actions'></th>
            @endif
        </tr>
    </tfoot>
    @endif
</table>

<div class="col-12">
    <h5 class="m-4 pb-2 mb-2 border-bottom mt-10 font-weight-bold">
        {{$label}}
        @if ((!isset($readonly) || !$readonly) && isset($actions["add"]) && $actions["add"])
        <a class="btn btn-primary btn-xs ml-1" href="javascript:void(0);" onclick="newTableRow('{{$model}}');">&nbsp;+&nbsp;</a>
        @endif
    </h5>
    <table class="m-4 table table-sm table-striped asociada" data-model="{{$model}}">
        <thead>
            <tr>
                <th style="display:none"></th>
                @foreach ($fields as $field)
                <th>{{$field->getLabel()}}</th>
                @endforeach
                @if (!isset($readonly) && (!isset($actions["update"]) || $actions["update"] || !isset($actions["delete"]) || $actions["delete"]) || isset($readonly) && !$readonly)
                <th class="delete">Acciones</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @if (isset($rows))
            @foreach($rows as $key => $row)
            <tr>
                @if(isset($row['__id']))
        <input type="hidden" name="table[{{$model}}][{{($key+1)}}][id]" value="{{$row['__id']}}" />
        @endif
        @foreach($row as $field)
        @if (is_object($field))
        <td>
            <div class="mt-1">
                @include($field->getViewFieldPath(), $field->getViewVars())
            </div>
        </td>
        @endif
        @endforeach
        @if (!isset($readonly) && (!isset($actions["update"]) || $actions["update"] || !isset($actions["delete"]) || $actions["delete"]) || isset($readonly) && !$readonly)
        <td>
            @if (isset($actions["update"]) && $actions["update"])
            <a class="btn btn-sm btn-dark mr-1" href="javascript:void(0);" onclick="editTableRow('{{$model}}', {{($key+1)}});"><i class="fa fa-edit"></i></a>
            @endif
            @if (isset($actions["delete"]) && $actions["delete"])
            @if(!isset($assoc) || !$assoc)
            <input type="hidden" name="table[{{$model}}][{{($key+1)}}][_delete]" value="0" />
            @endif
            <a class="btn btn-sm btn-danger" href="javascript:void(0);" onclick="deleteTableRow('{{$model}}', {{($key+1)}}, {{$assoc??false}});"><i class="fa fa-trash"></i></a>
            @endif
        </td>
        @endif
        </tr>
        @endforeach
        @endif
        </tbody>
    </table>
</div>

@if (!isset($readonly) || !$readonly || (isset($actions["add"]) && $actions["add"]))
<table id="row{{$model}}" style="display: none;">
    <tr>
        @foreach($fields as $field)
        <td>
            <div class="row">
                @php $field->setList(false); @endphp
                @include($field->getViewFieldPath(), array_merge($field->getViewVars(), [
                "name" => "##_REMOVE_##table[" . $model . "][##_ROW_NUMBER_##][" . $field->getOriginalName() . "]",
                "table" => true
                ]))
            </div>
        </td>
        @endforeach
    </tr>
</table>

<script>
    $(function () {
    if (typeof tableFields == "undefined") {
    tableFields = [];
    }
    if (typeof tableRules == "undefined") {
    tableRules = [];
    }
    tableFields['{{$model}}'] = @json($fields);
    tableRules['{{$model}}'] = @json(isset($tables_rules[$model])?$tables_rules[$model]["validator"]->toArray():[]);
    });
</script>
@endif

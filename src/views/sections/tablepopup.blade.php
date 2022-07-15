<div class="col-12">
    <h5 class="pb-2 mb-2 border-bottom mt-10 font-weight-bold">
        {{$label}}
        @if ((!isset($readonly) || !$readonly) && isset($actions["add"]) && $actions["add"])
        <a href="javascript:void(0);" class="btn btn-sm btn-primary btn-icon-split" onclick="addTableRow('{{$model}}');">
            <span class="icon text-white">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">{{$block["button"]??env('LABEL_TABLEPOPUP_ADD', 'Agregar Fila')}}</span>
        </a>
        @endif
    </h5>
    <table class="table table-sm table-striped asociada" data-model="{{$model}}" data-assoc="{{$assoc??0}}">
        <thead>
            <tr>
                @foreach ($fields as $field)
                <th style={{!$field->getIsVisible() || !$field->isvisibletable ? 'display:none':''}}>{{$field->getLabel()}}</th>
                @endforeach

                @foreach ($tablefieldsets as $fieldset)
                @foreach ($fieldset['fields'] as $field)
                <th style={{!$field->getIsVisible() || !$field->isvisibletable ? 'display:none':''}}>{{$field->getLabel()}}</th>
                @endforeach
                @endforeach

                @if ((!isset($readonly) || !$readonly) && (!isset($actions["update"]) || $actions["update"] || !isset($actions["delete"]) || $actions["delete"]))
                <th class="delete">Acciones</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @if (isset($rows))
            @foreach($rows as $key => $row)
            <tr data-number="{{($key+1)}}">
                @if(isset($row['__id']))
                <input type="hidden" name="table[{{$model}}][{{($key+1)}}][id]" value="{{$row['__id']}}" />
                @endif
                @foreach($row as $field)
                @if (is_object($field))
                <td style={{!$field->getIsVisible() || !$field->isvisibletable ? 'display:none':''}}>
                    <div class="mt-1">
                        @include($field->getViewFieldPath(), $field->getViewVars())
                    </div>
                </td>
                @endif
                @endforeach
                @if ((!isset($readonly) || !$readonly) && (!isset($actions["update"]) || $actions["update"] || !isset($actions["delete"]) || $actions["delete"]))
                <td>
                    @if (!isset($actions["update"]) || $actions["update"])
                    <a class="btn btn-circle btn-sm btn-secondary" href="javascript:void(0);" onclick="editTableRow('{{$model}}', {{($key+1)}});"><i class="fa fa-pencil-alt"></i></a>
                    @endif
                    @if (!isset($actions["delete"]) || $actions["delete"])
                    @if(!isset($assoc) || !$assoc)
                    <input type="hidden" name="table[{{$model}}][{{($key+1)}}][_delete]" value="0" />
                    @endif
                    <a class="btn btn-circle btn-sm btn-danger" href="javascript:void(0);" onclick="deleteTableRow('{{$model}}', {{($key+1)}}, {{$assoc??false}});"><i class="fa fa-trash"></i></a>
                    @endif
                </td>
                @endif
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
@php $tableFields = $fields; @endphp
@if ($readonly || (isset($actions["show"]) && $actions["show"]))
<form method="post" onsubmit="return false;" data-type="table" data-model="{{$model}}">
  <div id="tablePopupShow{{$model}}" data-model="{{$model}}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" @if(isset($width) && !empty($width)) style="max-width: {{$width}} !important;" @endif>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{$header ?? "Ver Fila"}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" onclick="closeTablePopup('{{$model}}', true);">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            @foreach($fields as $field)
            @php $field->setReadonly(true); @endphp
            @include($field->getViewFieldPath(), $field->getViewVars())
            @endforeach

            @foreach($tablefieldsets as $keyFieldset => $fieldset)
            <div class="col-md-{{$fieldset["cols"]??12}} mb-3" id="tablePopupShowBlock[{{$fieldset['id']??$keyFieldset}}]">
              @if (!empty($fieldset["label"]))
              <h5 class="mb-3 font-weight-bold">{{$fieldset["label"]}}</h5>
              @endif
              <div class="row">
                @foreach($fieldset['fields'] as $field)
                @php $field->setReadonly(true); @endphp
                @php $tableFields[] = $field; @endphp
                @include($field->getViewFieldPath(), $field->getViewVars())
                @endforeach
              </div>
            </div>
            @endforeach
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light btn-icon-split" onclick="$('#tablePopupShow{{$model}}').modal('hide');">
            <span class="icon text-white">
              <i class="fas fa-times"></i>
            </span>
            <span class="text">Cancelar</span>
          </button>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(function() {
      $('#tablePopupShow{{$model}}').on('hidden.bs.modal', function(e) {
        closeTablePopup('{{$model}}', true);
      });
      if (typeof tableFields == "undefined") {
        tableFields = [];
      }
      if (typeof tableRules == "undefined") {
        tableRules = [];
      }
      if (typeof tableInits == "undefined") {
        tableInits = [];
      }
      if (typeof tableActions == "undefined") {
        tableActions = [];
      }
      tableFields['{{$model}}'] = @json($tableFields);
      tableRules['{{$model}}'] = @json(isset($tables_rules[$model]) ? $tables_rules[$model]["validator"]->toArray() : []);
      tableInits['{{$model}}'] = @json($form_inits['tables'][$model] ?? []);
      tableActions['{{$model}}'] = @json($actions ?? []);
    });
  </script>
</form>
@endif
@php $tableFields = $fields; @endphp
@if ((isset($actions["update"]) && $actions["update"])|| (isset($actions["add"]) && $actions["add"]))
<form method="post" onsubmit="return false;" data-type="table" data-model="{{$model}}">
  <div id="tablePopup{{$model}}" data-model="{{$model}}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" @if(isset($width) && !empty($width)) style="max-width: {{$width}} !important;" @endif>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{$header ?? "Agregar Nueva Fila"}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" onclick="closeTablePopup('{{$model}}');">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            @foreach($fields as $field)
            @php $field->setList(false); @endphp
            @include($field->getViewFieldPath(), $field->getViewVars())
            @endforeach

            @foreach($tablefieldsets as $keyFieldset => $fieldset)
            <div class="col-md-{{$fieldset["cols"]??12}} mb-3" id="tablePopupBlock[{{$fieldset['id']??$keyFieldset}}]">
              @if (!empty($fieldset["label"]))
              <h5 class="mb-3 font-weight-bold">{{$fieldset["label"]}}</h5>
              @endif
              <div class="row">
                @foreach($fieldset['fields'] as $field)
                @php $tableFields[] = $field @endphp
                @php $field->setList(false); @endphp
                @include($field->getViewFieldPath(), $field->getViewVars())
                @endforeach
              </div>
            </div>
            @endforeach
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light btn-icon-split" onclick="$('#tablePopup{{$model}}').modal('hide');">
            <span class="icon text-white">
              <i class="fas fa-times"></i>
            </span>
            <span class="text">Cancelar</span>
          </button>
          @if(isset($actions["add"]) && $actions["add"])
          <button type="button" class="btn btn-success btn-icon-split" onclick="saveTableRow('{{$model}}', true);">
            <span class="icon text-white">
              <i class="fas fa-check-double"></i>
            </span>
            <span class="text">Agregar Otro</span>
          </button>
          @endif
          <button type="button" class="btn btn-success btn-icon-split" onclick="saveTableRow('{{$model}}');">
            <span class="icon text-white">
              <i class="fas fa-check"></i>
            </span>
            <span class="text">Agregar</span>
          </button>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(function() {
      $('#tablePopup{{$model}}').on('hidden.bs.modal', function(e) {
        closeTablePopup('{{$model}}');
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
@if ((isset($actions["update_iframe"]) && !empty($actions["update_iframe"]))|| (isset($actions["add_iframe"]) && !empty($actions["add_iframe"])))
<form method="post" onsubmit="return false;" data-type="table" data-model="{{$model}}">
  <div id="tablePopupIframe{{$model}}" data-model="{{$model}}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" @if(isset($width) && !empty($width)) style="max-width: {{$width}} !important;" @endif>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{$header ?? "Agregar Nueva Fila"}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" onclick="closeTablePopupIframe('{{$model}}');">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <iframe id="tablePopupIframe{{$model}}" width="100%" height="750px" webkitallowfullscreen mozallowfullscreen allowfullscreen>
          </iframe>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(function() {
      if (typeof tableFields == "undefined") {
        tableFields = [];
      }
      tableFields['{{$model}}'] = @json($tableFields);
      tableActions['{{$model}}'] = @json($actions ?? []);
    });
  </script>
</form>
@endif
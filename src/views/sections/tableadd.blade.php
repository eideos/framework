@if (!$readonly || isset($actions["add"]) && $actions["add"])
<form method="post" onsubmit="return false;" data-type="table" data-model="{{$model}}">
  <div id="tablePopup{{$model}}" data-model="{{$model}}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document" @if(isset($width) && !empty($width)) style="max-width: {{$width}} !important;" @endif>
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Agregar Nueva Fila</h5>
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
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-light btn-icon-split" onclick="$('#tablePopup{{$model}}').modal('hide');">
                    <span class="icon text-white">
                      <i class="fas fa-times"></i>
                    </span>
                    <span class="text">Cancelar</span>
                  </button>
                  <button type="button" class="btn btn-success btn-icon-split" onclick="saveTableRow('{{$model}}', true);">
                    <span class="icon text-white">
                      <i class="fas fa-check-double"></i>
                    </span>
                    <span class="text">Agregar Otro</span>
                  </button>
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
      $(function () {
        $('#tablePopup{{$model}}').on('hidden.bs.modal', function (e) {
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
      tableFields['{{$model}}'] = @json($fields);
      tableRules['{{$model}}'] = @json(isset($tables_rules[$model])?$tables_rules[$model]["validator"]->toArray():[]);
      tableInits['{{$model}}'] = @json($form_inits['tables'][$model] ?? []);
      });
  </script>
</form>
@endif

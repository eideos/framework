@if (!$readonly || (isset($actions["add"]) && $actions["add"]))
@php $tableFields = $fields; @endphp
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
@if (!$readonly || (isset($actions["add_iframe"]) && !empty($actions["add_iframe"])))
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

    function editTableRowIframe(model, number, jsonparams) {
      var params = JSON.parse(jsonparams);
      var url = params.url.replace('##id##', $("input[name='table[" + model + "][" + number + "][id]']").val());
      $('#tablePopupIframe' + model).on("shown.bs.modal", function() {
        $(this).find("iframe").attr("src", url);
      });
      $('#tablePopupIframe' + model).on("hidden.bs.modal", function() {
        $(this).find("iframe").attr("src", "");
      });
      $('#tablePopupIframe' + model).modal("show");
    }

    function addTableRowIframe(model, jsonparams) {
      var params = JSON.parse(jsonparams);
      var url = params.url;
      $('#tablePopupIframe' + model).on("shown.bs.modal", function() {
        $(this).find("iframe").attr("src", url);
      });
      $('#tablePopupIframe' + model).on("hidden.bs.modal", function() {
        $(this).find("iframe").attr("src", "");
      });
      $('#tablePopupIframe' + model).modal("show");
    }


    function addTableRowIframeManual(model, jsondata) {
      var data = JSON.parse(jsondata);
      if (tablesClones[model] === undefined) {
        tablesClones[model] = $("[id='tablePopup" + model + "']").html();
      }
      for (var i in tableFields[model]) {
        var fieldName = tableFields[model][i].name;
        var value = data[fieldName] === null ? "" : data[fieldName];
        $("[name='tablepopup[" + model + "][" + fieldName + "]']").val(value).change();
        $("[name='tablepopup[" + model + "][" + fieldName + "]_ro']").val(value);
      }

      var number = createTableIframeRow(model);

      if (data.id) {
        var hidden = $("<input />")
          .attr("type", "hidden")
          .attr("name", "table[" + model + "][" + number + "][id]")
          .val(data.id)
          .prependTo($("table[data-model='" + model + "'] tbody tr[data-number='" + number + "']"));
      }
    }

    function updateTableIframeRow(model, number) {
      for (var i in tableFields[model] || []) {
        var name = "table[" + model + "][" + number + "][" + tableFields[model][i].name + "]";
        var js_totext = eval(tableFields[model][i].js_totext);
        var js_tovalue = eval(tableFields[model][i].js_tovalue);
        var value = js_tovalue(model, tableFields[model][i]);
        var text = js_totext(model, tableFields[model][i]);
        $("[name='" + name + "']").val(value).siblings("div").html(text);
      }
    }

    function createTableIframeRow(model) {
      var number = tablesNextNumber[model] || 1;
      var row = $('<tr/>').attr("data-number", number);
      for (var i in tableFields[model] || []) {
        if (tableFields[model][i]["column"] !== false) {
          var name = "table[" + model + "][" + number + "][" + tableFields[model][i].name + "]";
          var js_totext = eval(tableFields[model][i].js_totext);
          var js_tovalue = eval(tableFields[model][i].js_tovalue);
          var isvisible = tableFields[model][i].isvisible;
          var isvisibletable = tableFields[model][i].isvisibletable;
          var value = js_tovalue(model, tableFields[model][i]);
          var text = $('<div/>').addClass("mt-1").html(js_totext(model, tableFields[model][i]));
          var hidden = $('<input/>').attr("name", name).attr("type", "hidden").val(value);
          var td = $('<td/>').append(text).append(hidden);
          if (!isvisible || !isvisibletable) {
            td.attr("style", "display:none");
          }
          td.appendTo(row);
        }
      }
      if (tableActions[model].update_iframe.length != -1 || tableActions[model].delete) {
        var td = $("<td/>");
        if (tableActions[model].update_iframe.length != -1) {
          $("<a/>")
            .addClass("btn btn-circle btn-sm btn-secondary mr-1")
            .attr("href", "javascript:void(0);")
            .attr("onclick", "editTableRowIframe('" + model + "', " + number + ", '" + JSON.stringify(tableActions[model].update_iframe) + "');")
            .html('<i class="fa fa-pencil-alt"></i>')
            .appendTo(td);
        }
        if (tableActions[model].delete) {
          $("<a/>")
            .addClass("btn btn-circle btn-sm btn-danger")
            .attr("href", "javascript:void(0);")
            .attr("onclick", "deleteTableRow('" + model + "', " + number + ");")
            .html('<i class="fa fa-trash"></i>')
            .appendTo(td);
        }
        td.appendTo(row);
      }
      $("table[data-model='" + model + "'] tbody").append(row);
      tablesNextNumber[model]++;
      return number;
    }

    function closeTablePopupIframe(model) {
      $('#tablePopupIframe' + model).modal('hide');
    }
  </script>
</form>
@endif
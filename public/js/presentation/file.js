function file_init(field, params) {
  var originalField = field;
  field = $("[name='" + params.name + "']");
  var language = "en"
  if (!empty(params.language)) {
    language = params.language;
  }
  var filetypes = "all";
  if (!empty(params.file_types)) {
    filetypes = params.file_types;
  }
  var max_file_size = "1500";
  if (!empty(params.max_file_size)) {
    max_file_size = params.max_file_size;
  }

  var fileinput_options = {
    showPreview: true,
    showDelete: true,
    showRemove: true,
    overwriteInitial: false,
    showClose: false,
    showCaption: false,
    browseLabel: '',
    removeLabel: '',
    language: language,
    maxFileSize: max_file_size,
    layoutTemplates: {
      main2: '{preview} {remove} {browse}',
    },
    allowedFileTypes: filetypes,
  };
  field.fileinput(fileinput_options);

  //seteo el valor del campo en el input original para que funcione el required de Validation
  field.on('change', function () {
    originalField.val(this.value);
  });

  field.on('fileloaded', function () {
    originalField.val(this.value);
  });
  
  if (OP == "E" && params.force_delete) {
    if (!empty(field.attr('data-default-preview-content'))) {
      $("#" + originalField.attr('name') + "_delete").show();
    }
  }

  $("#" + originalField.attr('name') + "_delete").on("click", function () {
    originalField.val("");
    field.fileinput('destroy');
    field.fileinput('refresh', fileinput_options);
    $(this).hide();
  });
}

function file_topopup(model, number, field) {
  var html_preview = $("[id='table[" + model + "][" + number + "][" + field + "]Preview']").html();
  $("[name='tablepopup[" + model + "][" + field + "]']").parent().find('.file-preview-thumbnails').html(html_preview);
  presentation_topopup(model, number, field);
}

function file_tovalue(model, field) {
  var number = tableEditNumber;
  if (number == null) {
    number = tablesNextNumber[model] || 1;
  }
  var input_file_name = "table{" + model + "}{" + number + "}{" + field.name + "}";
  var clone_input_file = $("[name='tablepopup[" + model + "][" + field.name + "]_file']").clone();
  $("[name='" + input_file_name + "_file']").remove();
  clone_input_file.attr('name', input_file_name + "_file");
  clone_input_file.attr('id', input_file_name + "File");
  clone_input_file.attr('style', 'display:none');
  $("table[data-model='" + model + "']").append(clone_input_file);
  return $("[name='tablepopup[" + model + "][" + field.name + "]']").val();
}
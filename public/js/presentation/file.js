function file_init(field, params) {
  field = $("[name='" + params.name + "']");
  field.fileinput({
    showPreview: true,
    showDelete: true,
    showRemove: true,
    overwriteInitial: false,
    showClose: false,
    showCaption: false,
    browseLabel: '',
    removeLabel: '',
    layoutTemplates: {
      main2: '{preview} {remove} {browse}'
    }
  });
}

function file_topopup(model, number , field) {
  var html_preview = $("[id='table["+model+"]["+number+"]["+field+"]Preview']").html();
  $("[name='tablepopup[" + model + "][" + field + "]']").parent().find('.file-preview-thumbnails').html(html_preview);
  presentation_topopup(model, number, field);
}

function file_tovalue(model, field) {
  var number = tableEditNumber;
  if (number == null){
    number = tablesNextNumber[model] || 1;
  }
  var input_file_name = "table{" + model + "}{" + number + "}{" + field.name + "}";
  var clone_input_file = $("[name='tablepopup[" + model + "][" + field.name + "]_file']").clone();
  $("[name='" + input_file_name + "_file']").remove();
  clone_input_file.attr('name', input_file_name + "_file");
  clone_input_file.attr('id', input_file_name + "File");
  clone_input_file.attr('style', 'display:none');
  $("table[data-model='" + model+ "']").append(clone_input_file);
  return $("[name='tablepopup[" + model + "][" + field.name + "]']").val();
}
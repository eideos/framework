function daterange_init(field, params) {
  $('[name="tmp_' + field.attr("name") + '_from"]').datepicker({
    uiLibrary: 'bootstrap4',
    locale: 'es-es',
    format: 'dd/mm/yyyy'
  });
  $('[name="tmp_' + field.attr("name") + '_to"]').datepicker({
    uiLibrary: 'bootstrap4',
    locale: 'es-es',
    format: 'dd/mm/yyyy'
  });
  $('[name="tmp_' + field.attr("name") + '_from"],[name="tmp_' + field.attr("name") + '_to"]').change(function() {
    var from = $('[name="tmp_' + field.attr("name") + '_from"]').val();
    var to = $('[name="tmp_' + field.attr("name") + '_to"]').val();
    field.val(from + "|" + to);
  }).change();
}

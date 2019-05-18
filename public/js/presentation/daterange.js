function daterange_init(field, params) {
  var name = field.attr("name");
  $("[name='" + name + "[from]']").datepicker({
      uiLibrary: 'bootstrap4',
      locale: 'es-es',
      format: 'dd/mm/yyyy'
  });
  $("[name='" + name + "[to]']").datepicker({
      uiLibrary: 'bootstrap4',
      locale: 'es-es',
      format: 'dd/mm/yyyy'
  });
}
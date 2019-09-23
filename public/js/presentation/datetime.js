function datetime_init(field, params) {
  if (field.siblings("[readonly]").length == 0) {
    field.datetimepicker({
      uiLibrary: 'bootstrap4',
      locale: 'es-es',
      format: params.format,
      modal: true,
      footer: true
    });
  }
}

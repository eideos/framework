function datetime_init(field, params) {
  if (field.siblings("[readonly]").length == 0) {
    field.datetimepicker({
      uiLibrary: 'bootstrap4',
      format: params.format,
      modal: true,
      footer: true
    });
  }
}

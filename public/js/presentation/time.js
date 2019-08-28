function time_init(field, params) {
    if (field.siblings("[readonly]").length == 0) {
      field.timepicker({
          uiLibrary: 'bootstrap4',
          locale: 'es-es',
          format: params.format || 'H:MM'
      });
    }
}

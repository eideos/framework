function date_init(field, params) {
    if (field.siblings("[readonly]").length == 0) {
      field.datepicker({
          uiLibrary: 'bootstrap4',
          locale: 'es-es',
          format: 'dd/mm/yyyy'
      });
    }
}

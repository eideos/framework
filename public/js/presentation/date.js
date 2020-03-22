function date_init(field, params) {
  if (field.siblings("[readonly]").length == 0) {
    var paramsdp = {
        uiLibrary: 'bootstrap4',
        locale: 'es-es',
        format: 'dd/mm/yyyy'
    };
    if(params.datepicker){
      paramsdp = params.datepicker;
      if(paramsdp.minDate){
        console.log(paramsdp.minDate);
        paramsdp.minDate = eval(paramsdp.minDate);
      }
      if(paramsdp.maxDate){
        paramsdp.maxDate = eval(paramsdp.maxDate);
      }
    }
    field.datepicker(paramsdp);
  }
}

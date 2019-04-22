function money_init(field, params) {
  field.mask(params.mask || "#.##0,00", params);
}

function money_totext(model, field) {
  return number_format($("[name='tablepopup[" + model + "][" + field.name + "]']").val().replace(/\./g, ""), 2, ",", ".");
}

function money_int_init(field, params) {
  field.mask(params.mask || "#.##0", params);
}

function money_int_totext(model, field) {
    return number_format($("[name='tablepopup[" + model + "][" + field.name + "]']").val().replace(/\./g, ""), 0, "", ".");
}

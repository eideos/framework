function checkbox_tovalue(model, field) {
  return $("[name='tablepopup[" + model + "][" + $(field).attr('name') + "][]']:checked").map(function () {
    return this.value;
  }).get().join(",");
}

function checkbox_totext(model, field) {
  return $("[name='tablepopup[" + model + "][" + $(field).attr('name') + "][]']:checked").map(function () {
    return $(this).siblings('label').html();
  }).get().join(", ");
}
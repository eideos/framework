function tags_init(field, params) {
    field.tagsinput({
        delimiter: ';',
        confirmKeys: [13, 59],
        tagClass: 'badge badge-info'
    });
    $(".bootstrap-tagsinput").addClass("form-control");
}

function tags_topopup(model, number, field) {
    var value = $("[name='table[" + model + "][" + number + "][" + field + "]']").val();
    $("[name='tablepopup[" + model + "][" + field + "]']").tagsinput('add', value);
}

function tags_tovalue(model, field) {
    return $("[name='tablepopup[" + model + "][" + field.name + "]']").tagsinput("items").join(";");
}

function tags_totext(model, field) {
    return $("[name='tablepopup[" + model + "][" + field.name + "]']").tagsinput("items").join(";");
}
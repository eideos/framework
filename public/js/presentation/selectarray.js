function selectarray_init(field, params) {
    uniqueInTable(field);
}
function selectarray_totext(model, field) {
    return $("[name='tablepopup[" + model + "][" + field.name + "]']").find("option:selected").text();
}
function getModelNameField(field) {
    var field_name = field.attr("name");
    return field_name.substring(field_name.indexOf("[") + 1, field_name.indexOf("]"));
}

function uniqueInTable(field) {
    var uniqueInTable = field.attr("data-unique-table");
    if (uniqueInTable !== undefined && uniqueInTable) {
        var field_name = field.attr("name");
        var field_value = field.val();
        var model_name = getModelNameField(field);
        var campo_name = field_name.substring(13 + model_name.length, field_name.length - 1);
        var disables = [];
        $("input[name*='table[" + model_name + "][").each(function () {
            if (this.name.indexOf(campo_name) !== -1) {
                if ($(this).parents("tr").first().attr("data-deleted") !== "1" && this.value !== field_value) {
                    disables.push(this.value);
                }
            }
        });
        $("[name='" + field_name + "'] option").each(function () {
            if ($.inArray(this.value, disables) !== -1) {
                $(this).prop("disabled", true);
            } else {
                $(this).prop("disabled", false);
            }
        });
    }
}
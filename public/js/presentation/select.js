function select_init(field, params) {
    var listen = field.attr("data-listen");
    var listenCallback = field.attr("data-listen-callback");
    var field_value = field.val();
    var field_desc = field.find("option:selected").text();
    if (listen !== undefined) {
        var listen_field = $("[name='" + listen.replace("\\", "__") + "']");
        listen_field.change(function () {
            field.empty();
            if (listen_field.siblings("label").length) {
                var listen_field_label = listen_field.siblings("label").text();
            } else {
                var listen_field_label = listen_field.parent().siblings("label").text();
            }
            if (this.value == "") {
                field.append('<option value="">(seleccione una opcion de ' + listen_field_label + ')</option>');
                return;
            }
            var displayfield = field.attr("data-displayfield");
            var requestParams = {
                model: field.attr("data-model"),
                listen_model: listen_field.attr("data-model"),
                listen_model_id: this.value,
                foreign_key: listen_field.attr("name"),
                display_field: field.attr("data-searchfield"),
                conditions: {}
            };
            if (params.conditions) {
                requestParams.conditions = params.conditions;
            }
            if (params.active) {
                requestParams.conditions.active = params.active;
            }
            if (typeof listenCallback !== "undefined") {
                if (typeof window[listenCallback] !== "undefined") {
                    window[listenCallback](field, requestParams, field_value, field_desc);
                    uniqueInTable(field);
                }
            } else {
                $.getJSON(APP_URL + "select?", requestParams, function (data) {
                    field.append('<option value="" />');
                    for (var i in data) {
                        var selected = "";
                        if (field_value == data[i].id) {
                            selected = "selected";
                        }
                        field.append('<option value="' + data[i].id + '" ' + selected + '>' + (data[i][displayfield] || data[i].id) + '</option>');
                    }
                    uniqueInTable(field);
                });
            }
        }).change();
    }
    if (params.callbackOptions && typeof params.callbackOptions !== "undefined") {
        if (typeof window[params.callbackOptions] !== "undefined") {
            window[params.callbackOptions](field, params, field_value, field_desc);
            uniqueInTable(field);
        }
    }
    uniqueInTable(field);
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

function select_totext(model, field) {
    if ($("[name='tablepopup[" + model + "][" + field.name + "]_ro']").length) {
        return $("[name='tablepopup[" + model + "][" + field.name + "]_ro']").val();
    }
    return $("[name='tablepopup[" + model + "][" + field.name + "]'] option:selected").text();
}

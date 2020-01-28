function autocomplete_init(field, params) {
  var ac_field = $("[name='" + field.attr("name") + "_ac']");
  var keyField = field.attr('data-keyfield');
  var displayField = field.attr("data-displayfield");
  var listen = field.attr("data-listen");
  if (listen) {
    var listen_field = $("[name='" + listen + "']");
    var listen_field_value = listen_field.val();
    listen_field.change(function () {
      if (listen_field_value != this.value) {
        field.val("").change();
        ac_field.val("");
      }
    });
  }
  ac_field
    .typeahead({
      source: function (request, response) {
        var requestParams = {
          model: field.attr("data-model"),
          str: request,
          keyField: keyField,
          displayField: displayField,
          joins: params.joins || []
        };
        if (params.conditions) {
          requestParams.conditions = params.conditions;
        }
        if (params.active) {
          requestParams.conditions.active = params.active;
        }
        if (listen) {
          requestParams.conditions[listen_field.attr("name")] = listen_field.val();
        }
        $.getJSON(APP_URL + "autocomplete?", requestParams, function (data) {
          response(data);
        });
      },
      displayText: function (item) {
        return item["displayField"];
      },
      autoSelect: true,
      minLength: 2,
      updater: function (item) {
        field.val(item[keyField]).change();
        return item;
      }
    })
    .keyup(function (e) {
      if (e.keyCode != 13 && field.val() != "") {
        field.val("").change();
      }
    });
}

function autocomplete_totext(model, field) {
  if ($("[name='tablepopup[" + model + "][" + field.name + "]_ac']").length) {
    return $("[name='tablepopup[" + model + "][" + field.name + "]_ac']").val();
  }
  return "";
}

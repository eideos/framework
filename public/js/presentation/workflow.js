function workflow_init(field, params) {
    if (OP != 'I') {
        new WorkflowButtons(field.attr('name'), params.callback, params);
    }
}

function WorkflowButtons(fieldName, callbackName, params) {
    // attributes
    var self = this,
        options = [],
        field,
        callback,
        globalParams;
    // private
    var setField = function () {
        field = $("[name='" + fieldName + "']");
    };
    var setGlobalParams = function () {
        globalParams = params;
    };
    var setCallback = function () {
        callback = callbackName;
    };
    var hideElements = function () {
        $("[name='" + fieldName + "']").parent().hide();
        $("form button[type='submit']").hide();
    };
    var populateOptions = function () {
        field.find("option[value!='']").each(function () {
            options.push({
                step: $(this).val(),
                label: $(this).text(),
                order: $(this).attr("data-order") || 0
            });
        }).get();
    };
    var generateButtons = function () {
        if (!empty(globalParams.callbackOptions)) {
            if (isFunction(globalParams.callbackOptions)) {
                setTimeout(function () {
                    var fnCallbackOptions = eval(globalParams.callbackOptions);
                    drawOptions(fnCallbackOptions(field, params, options));
                }, 1);
            }
        } else {
            drawOptions(options);
        }
    };
    var drawOptions = function (opt) {
        for (var i in opt) {
            var colorClass = opt[i].order == 0 ? "primary" : (opt[i].order > 0 ? "success" : "danger");
            var iconClass = opt[i].order == 0 ? "check" : (opt[i].order > 0 ? "arrow-right" : "arrow-left");
            var button = $("<button/>")
                .attr("data-step", opt[i].step)
                .addClass("btn btn-" + colorClass + " btn-icon-split ml-2")
                .append($('<span />').addClass('icon text-white').html('<i class="fas fa-' + iconClass + '"></i>'))
                .append($('<span />').addClass('text').html(opt[i].label))
                .click(function () {
                    self.submit($(this).attr("data-step"));
                    return false;
                });
            $(".maint-actions").append(button);
        }
    }
    // public
    this.submit = function (step) {
        if (!empty(callback)) {
            //El submit tiene que quedar del lado del callback por Sincronismo
            if (isFunction(callback)) {
                var fnSubmitCallback = eval(callback);
                fnSubmitCallback(field, step, params);
            } else {
                field.val(step);
                $("form.maint button[type='submit']").click();
            }
        } else {
            field.val(step);
            $("form.maint button[type='submit']").click();
        }
    };
    // init
    setField();
    setCallback();
    setGlobalParams();
    hideElements();
    populateOptions();
    generateButtons();
}

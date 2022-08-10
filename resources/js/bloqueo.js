function bloqueoHearthbeat() {
    $('.heartbeat').fadeTo('slow', 0.8).animate({
        width: "85px",
        height: "95px",
        'font-size': "65px"
    }, 1000).animate({
        width: "50px",
        height: "56px",
        'font-size': "40px"
    }, 1000).fadeTo('slow', 0.4);
}

function bloqueoRegistroActualizar(time) {
    $.getJSON(APP_URL + "blocks/ajax_check_status/" + MODEL + "/" + MODEL_ID, function (jdata) {
        if (jdata.status == 'expired') {
            $("#cancelButton").click();
            return;
        } else if (jdata.status == 'alert') {
            swal("Alerta Bloqueo", "¡En " + jdata.time + " minutos se va a vencer el tiempo disponible para modificar el registro!", "warning");
            setTimeout("swal.close();", time / 2);
        }
    });
}

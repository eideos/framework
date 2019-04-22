@include('framework::sections.jsvars')
<script type="text/javascript">
$(function () {
    var timeChequeo = 5 * 60 * 1000; // 5 minutos
    var timeLatido = 1 * 60 * 1000; // 1 minuto
    setInterval("bloqueoRegistroActualizar(" + timeChequeo + ");", timeChequeo);
    setInterval("bloqueoHearthbeat();", timeLatido);
});
</script>
<div class="heartbeat bg-warning" data-toggle="tooltip" data-placement="bottom" title="Otros usuarios no podrán utilizar este registro mientras Ud. lo esté viendo.">
    <i class="fa fa-lock" aria-hidden="true"></i>
</div>

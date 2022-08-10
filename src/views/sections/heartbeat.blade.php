@include('framework::sections.jsvars')
<script type="text/javascript">
    var FMW_MINUTES_CHECK_BLOCK = "{{env('FMW_MINUTES_CHECK_BLOCK', 5)}}";
    var FMW_MINUTES_HEARTBEAT_BLOCK = "{{env('FMW_MINUTES_HEARTBEAT_BLOCK', 1)}}";
    $(function() {
        var timeChequeo = FMW_MINUTES_CHECK_BLOCK * 60 * 1000; // 5 minutos
        var timeLatido = FMW_MINUTES_HEARTBEAT_BLOCK * 60 * 1000; // 1 minuto
        setInterval("bloqueoRegistroActualizar(" + timeChequeo + ");", timeChequeo);
        setInterval("bloqueoHearthbeat();", timeLatido);
    });
</script>
<div class="heartbeat bg-warning" data-toggle="tooltip" data-placement="bottom" title="Otros usuarios no podrán utilizar este registro mientras Ud. lo esté viendo.">
    <i class="fa fa-lock" aria-hidden="true"></i>
</div>
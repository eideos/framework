@php $jsondata = json_encode(session()->get("data")); @endphp
<script type="text/javascript">
    parent.closeTablePopupIframe('{{session()->get("model")}}');
    parent.addTableRowIframeManual('{{session()->get("model")}}', @json($jsondata));
</script>
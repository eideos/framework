<script type="text/javascript">
    parent.closeTablePopupIframe('{{session()->get("model")}}');
    parent.addTableRowIframeManual('{{session()->get("model")}}', '{{json_encode(session()->get("data"),true)}}');
</script>
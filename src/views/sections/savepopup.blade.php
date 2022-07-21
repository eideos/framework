@php $jsondata = json_encode(session()->get("data")); @endphp
@if(session()->get("action") == 'store')
<script type="text/javascript">
    parent.closeTablePopupIframe('{{session()->get("model")}}');
    parent.addTableRowIframeManual('{{session()->get("model")}}', @json($jsondata));
</script>
@endif
@if(session()->get("action") == 'update')
<script type="text/javascript">
    parent.closeTablePopupIframe('{{session()->get("model")}}');
    parent.editTableRowIframeManual('{{session()->get("model")}}', @json($jsondata));
</script>
@endif
<div class="modal fade" id="{{$name??"files"}}_preview" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><label id="{{$name??"files"}}_preview_filename"></label></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div id="{{$name??"files"}}_preview_body" class="modal-body" data-preview-height="{{$previewHeight or "400px"}}">
                <embed id="{{$name??"files"}}_preview_embed" src="/files/download/{{$table??"files"}}/{{$attach['id'] or "-1"}}" type="{{$attach['mimetype'] or ""}}" width="100%" height="{{$previewHeight or "400px"}}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>    

<script type="text/javascript">
    function previewFile(tabla, id, name, mimetype, storage) {
        var url = '/files/display/' + tabla + '/' + id;
        $('#{{ $name or "files" }}_preview_filename').html("");
        $('#{{ $name or "files" }}_preview_filename').html(name);
        var preview_height = $('#{{ $name or "files" }}_preview_body').attr("data-preview-height");
        if(strstr(mimetype, "officedocument")){
            var url = APP_URL + storage.replace("public", "storage");
            console.log(url);
            var preview = $("<iframe>").attr("id", '{{ $name or "files" }}_preview_embed').attr('type', mimetype).attr("width", "100%").attr("height", preview_height).attr("src", "https://view.officeapps.live.com/op/embed.aspx?src=" + url);
        } else{
            var preview = $("<iframe>").attr("id", '{{ $name or "files" }}_preview_embed').attr('type', mimetype).attr("width", "100%").attr("height", preview_height).attr("src", url);
        }
        $('#{{ $name or "files" }}_preview_body').html(preview);
        $('#{{ $name or "files" }}_preview').modal({'show': true});
    }

    function deleteFile(table, id) {
        if (swal) {
            swal({
                title: '¿Está seguro que desea eliminar el archivo?',
                text: "!Esta acción no podrá revertirse!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: "Cancelar",
                confirmButtonText: 'Si, eliminar!'
            }).then(function (res) {
                if (res.value) {
                    $.ajax({
                        url: '/files/delete',
                        dataType: "json",
                        method: 'POST',
                        data: {table: table, id: id, _token: '{{csrf_token()}}'}
                    }).then(function (resdelete) {
                        if (resdelete.status === "OK") {
                            $("#preview_" + id).remove();
                            swal('¡Archivo Eliminado!', 'El archivo se eliminó correctamente.', 'success');
                        } else {
                            swal('¡No se pudo eliminar!', 'No se pudo eliminar el archivo. Intente nuevamente o contacte al administrador.', 'error');
                        }
                    });
                }
            });
        } else {
            var res = confirm("¿Está seguro que desea eliminar el archivo?");
            if (res) {
                $.ajax({
                    url: '/files/delete',
                    dataType: "json",
                    method: 'POST',
                    data: {table: table, id: id, _token: '{{csrf_token()}}'}
                }).then(function (resdelete) {
                    if (resdelete.status === "OK") {
                        $("#preview_" + id).remove();
                        alert('¡Archivo eliminado correctamente!');
                    } else {
                        alert('¡No se pudo eliminar el archivo!');
                    }
                });
            }
        }
    }
</script>
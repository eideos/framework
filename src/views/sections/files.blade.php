<div class="col-12 {{$name ?? "attach"}}_increment">
    <h5 class="pb-2 mb-2 border-bottom mt-10 font-weight-bold">
        {{$label ?? "Adjuntos"}}
        @if ((!isset($readonly) || !$readonly) && isset($actions["add"]) && $actions["add"])
        <a id="{{$name ?? "attach"}}_btnAdd" class="btn btn-sm btn-primary btn-icon-split" href="javascript:void(0);" onclick="newTableRow('{{$model}}');">
            <span class="icon text-white">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">{{$block["button"]??env('FMW_LABEL_FILES_ADD', 'Agregar Adjunto')}}</span>
        </a>
        @endif
    </h5>
    @if (!empty($warning))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {!! $warning !!}
    </div>
    @endif

    @if (!empty($info))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {!! $info !!}
    </div>
    @endif
    <table class="table table-sm table-striped">
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Nombre</th>
                @if(isset($showMimetype)&&$showMimetype)
                <th>Mimetype</th>
                @endif
                @if(isset($descEnabled)&&$descEnabled)
                <th>Observaciones</th>
                @endif
                <th>Acciones</th>
            </tr>
        </thead>
        @if(isset($attaches) && count($attaches))
        <tbody>
            @foreach($attaches as $attach)
            <tr class="file-preview-frame explorer-frame  file-preview-initial file-sortable kv-preview-thumb" id="preview_{{$attach['id']}}" data-fileindex="init_{{$attach['id']}}" data-template="image">
                <td class="kv-file-content">
                    <div class="file-preview-other">
                        <span class="file-other-icon">
                            <i class="{{files_get_icon_from_extension($attach['extension'])}}"></i>
                        </span>
                    </div>
                </td>
                <td class="file-details-cell">
                    <div class="explorer-caption" title="{{$attach['name']}}">{{$attach['name']}}</div> <samp>({{implode(" ", files_get_size_formatted($attach['size']))}})</samp>
                </td>
                @if(isset($showMimetype)&&$showMimetype)
                <td class="file-details-cell">
                    <div class="explorer-caption" title="{{$attach['mimetype']}}">{{$attach['mimetype']}}</div>
                </td>
                @endif
                @if(isset($descEnabled)&&$descEnabled)
                <td class="file-details-cell">
                    <div class="explorer-caption" title="{{$attach['observation']}}">{{$attach['observation']}}</div>
                </td>
                @endif
                <td class="file-actions-cell">
                    <div class="file-actions">
                        <div class="file-footer-buttons">
                            <div class="btn-group" role="group">
                                @if ((!isset($readonly) || !$readonly) && isset($actions["delete"]) && $actions["delete"])
                                <a href="javascript:void(0);" onclick="deleteFile('{{snake_plural_middle_case(str_replace("App__","",$model))}}','{{$attach['id']}}')" class="btn btn-danger btm-sm">
                                    <i class="fa fa-trash"></i>
                                </a>
                                @endif
                                <a href="/files/download/{{snake_plural_middle_case(str_replace("App__","",$model))}}/{{$attach['id']}}" class="btn btn-primary btm-sm">
                                    <i class="fa fa-download"></i>
                                </a>
                                <a href="javascript:void(0);" onclick="previewFile('{{snake_plural_middle_case(str_replace("App__","",$model))}}','{{$attach['id']}}','{{$attach['name']}}','{{$attach['mimetype']}}', '{{$attach['storage']}}')" class="btn btn-primary btm-sm">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
        @endif
    </table>
</div>
<table style="display: none;">
    <tbody class="{{$name ?? "attach"}}_clone">
        <tr class="{{$name ?? "attach"}}_row" id="cloned_row_X_IDX_X">
            <td colspan="2">
                <div class="input-group form-group">
                    <input type="file" name="{{$name ?? "attach"}}[]" class="form-control btn btn-xs" accept="@implode_file_extensions(',.', $allowedFileExtensions??[])">
                </div>
            </td>
            @if(isset($descEnabled)&&$descEnabled)
            <td class="file-details-cell">
                <textarea name="{{$name ?? "attach"}}_X_IDX_X_desc" class="form-control btm-sm"></textarea>
            </td>
            @endif
            <td class="file-actions-cell">
                <div class="btn-group" role="group">
                    <a id="{{$name ?? "attach"}}_btnRemove_X_IDX_X" data-removeindex="X_IDX_X" class="btn btn-danger btm-sm ml-3 {{$name ?? "attach"}}_btnRemove" href="javascript:void(0);">
                        <i class="fa fa-trash"></i>
                    </a>
                </div>
            </td>
        </tr>
    </tbody>
</table>

@include('framework::sections.filespreviewmodal')

<script>
    var name = "{{$name or 'attach'}}";
    $("#" + name + "_btnAdd").click(function() {
        var html = $("." + name + "_clone").html();
        html = html.replace(/X_IDX_X/g, ($("input[name='" + name + "[]']").length - 1));
        $("." + name + "_increment .table").append(html);
    });
    $("body").on("click", "." + name + "_btnRemove", function() {
        var removeIndex = $(this).data('removeindex');
        var lastIndex = $("input[name='" + name + "[]']").length;
        $("#cloned_row_" + removeIndex).remove();
        for (var i = removeIndex; i < lastIndex; i++) {
            $("#cloned_row_" + (i + 1)).attr('id', "cloned_row_" + i);
            $("#" + name + "_btnRemove_" + (i + 1)).attr('data-removeindex', i);
            $("#" + name + "_btnRemove_" + (i + 1)).attr('id', "#" + name + "_btnRemove_" + i);
            $("textarea[name='" + name + "_" + (i + 1) + "_desc']").attr("name", name + "_" + i + "_desc");
        }
    });
</script>
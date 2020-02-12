<div class="col-12 {{$name or "attach"}}_increment">
    <div class='file-preview'>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th colspan="5">
                        @if(isset($readonly)&&$readonly)
                        <div style="display:none">
                            @endif
                            <button id="{{$name or "attach"}}_btnAdd" style="font-size: .875rem !important;" class="btn btn-primary btn-xs ml-2" type="button"><i class="fas fa-plus"></i>&nbsp;{{(isset_notempty($labels['add']) ? $labels['add'] : '')}}</button>
                            @if(isset($readonly)&&$readonly)
                        </div>
                        @endif
                    </th>
                </tr>
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
                    <td class="file-actions-cell" style="padding: 1.55rem; vertical-align: top; border-top: 1px solid #dee2e6;">
                        <div class="file-actions">
                            <div class="file-footer-buttons">
                                <div class="btn-group" role="group">
                                    @if(!isset($readonly)||!$readonly)
                                    <a href="javascript:void(0);" onclick="deleteFile('{{snake_plural_middle_case(str_replace("App__","",$model))}}','{{$attach['id']}}')" class="btn btn-danger btn-xs">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    @endif
                                    <a href="/files/download/{{snake_plural_middle_case(str_replace("App__","",$model))}}/{{$attach['id']}}" class="btn btn-primary btn-xs">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    <a href="javascript:void(0);" onclick="previewFile('{{snake_plural_middle_case(str_replace("App__","",$model))}}','{{$attach['id']}}','{{$attach['name']}}','{{$attach['mimetype']}}')" class="btn btn-primary btn-xs">
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
</div>
<table style="display: none;">
    <tbody class="{{$name or "attach"}}_clone">
        <tr class="{{$name or "attach"}}_row" id="cloned_row_X_IDX_X">
            <td colspan="{{isset($descEnabled)&&$descEnabled?2:4}}">
                <div class="form-group col-md-12">
                    <div class="input-group form-group">
                        <input type="file" name="{{$name or "attach"}}[]" class="form-control btn-xs" accept="@implode_file_extensions(',.', $allowedFileExtensions??[])">
                    </div>
                </div>
            </td>
            @if(isset($descEnabled)&&$descEnabled)
            <td colspan="2">
                <div class="form-group col-md-12">
                    <div class="input-group form-group">
                        <textarea name="{{$name or "attach"}}_X_IDX_X_desc" class="form-control btn-xs"></textarea>
                    </div>
                </div>
            </td>
            @endif
            <td colspan="1">
                <div class="input-group-btn">
                    <button class="btn btn-danger btn-xs ml-2 {{$name or "attach"}}_btnRemove" id="{{$name or "attach"}}_btnRemove_X_IDX_X" data-removeindex="X_IDX_X" style="font-size: .775rem !important;" type="button"><i class="fas fa-trash"></i></button>
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
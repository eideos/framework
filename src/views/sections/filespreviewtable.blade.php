@if(count($attaches))
<div class='file-preview'>
    <table class="table table-hover">
        <thead>
            <th>Tipo</th>
            <th>Nombre</th>
            <th>Mimetype</th>
            <th>Observaciones</th>
            <th>Acciones</th>
        </thead>
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
                <td class="file-details-cell">
                    <div class="explorer-caption" title="{{$attach['mimetype']}}">{{$attach['mimetype']}}</div>
                </td>
                <td class="file-details-cell">
                    <div class="explorer-caption" title="{{$attach['observation']}}">{{$attach['observation']}}</div>
                </td>
                <td class="file-actions-cell" style="padding: 1.55rem; vertical-align: top; border-top: 1px solid #dee2e6;">
                    <div class="file-actions">
                        <div class="file-footer-buttons">
                            <div class="btn-group" role="group">
                                @if(!isset($readonly)||!$readonly)
                                <a href="javascript:void(0);" onclick="deleteFile('{{$table}}','{{$attach['id']}}')" class="btn btn-danger btn-md">
                                    <i class="fa fa-trash"></i>
                                </a>
                                @endif
                                <a href="/files/download/{{$table}}/{{$attach['id']}}" class="btn btn-primary btn-md">
                                    <i class="fa fa-download"></i>
                                </a>
                                <a href="javascript:void(0);" onclick="previewFile('{{$table}}','{{$attach['id']}}','{{$attach['name']}}','{{$attach['mimetype']}}','{{$attach['storage']}}')" class="btn btn-primary btn-md">
                                    <i class="fa fa-search-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$attaches->fragment('attaches')->render()}}
</div>
@endif
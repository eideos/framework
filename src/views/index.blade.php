@extends($layout)

@section('title', $title ?? '')

@section('content')

<script type="text/javascript">var OP = "I";</script>

@foreach($cssincludes as $cssfile)
<link rel="stylesheet" href="{{ URL::asset($cssfile) }}" />
@endforeach

@foreach($jsincludes as $jsfile)
<script type="text/javascript" src="{{ URL::asset($jsfile) }}"></script>
@endforeach

@if (\Session::has('success'))
<div class="alert alert-success">
    <strong><i class="fas fa-check-circle"></i> Correcto:</strong> {{ \Session::get('success') }}
</div>
@endif
@if (\Session::has('danger'))
<div class="alert alert-danger">
    <strong><i class="fas fa-exclamation-circle"></i> Error:</strong> {{ \Session::get('danger') }}
</div>
@endif

@includeFirst(['sections.breadcrumb', 'framework::sections.breadcrumb'])

<div class="row">
    <div class="col-12">
        <h4 class="pb-2 mb-2 border-bottom">
            {{isset($title) ? $title : 'Listado'}}
            @foreach ($data['actions'] as $action)
            @php $controller = $action['controller'] ?? $controller @endphp
            @if (isset($action["global"]) && $action["global"] && is_authorized($controller,$action["action"]))
            <a href="{{fmw_action($controller, $action['action'])}}" class="btn btn-sm {{$action['class']??'btn-primary'}} btn-icon-split">
              <span class="icon text-white">
                <i class="fas fa-{{$action["icon"]}}"></i>
              </span>
              <span class="text">{{$action["label"]}}</span>
            </a>
            @endif
            @endforeach
            <div class="float-right">
                <div class="btn-group" role="group">
                    <a href="javascript:void(0);" class="btn btn-light btn-sm" data-toggle="modal" data-target="#filtros">
                        <i class="fa fa-{{$filterIcon??"search"}}" data-toggle="tooltip" data-placement="top" title="Filtrar"></i>
                    </a>
                    @if(url_route_exists(Request::url() . "/export/xls"))
                    <div id="export" style="display: none;"></div>
                    <a href="javascript:void(0);" class="btn btn-light btn-sm" onclick="exportClick('xlsx')">
                        <i class="fa fa-file-excel" data-toggle="tooltip" data-placement="top" title="Descargar Excel" ></i>
                    </a>
                    <a href="javascript:void(0);" class="btn btn-light btn-sm" onclick="exportClick('csv')">
                        <i class="fa fa-file-export" data-toggle="tooltip" data-placement="top" title="Descargar CSV" ></i>
                    </a>
                    <!--
                    <a href="javascript:void(0);" class="btn btn-light btn-sm" onclick="exportClick('pdf')">
                        <i class="fa fa-file-pdf" data-toggle="tooltip" data-placement="top" title="Descargar PDF" ></i>
                    </a>
                    -->
                    @endif
                </div>
            </div>
            <div class="float-right limit mr-3">
                <select class="form-control form-control-sm" id="limit" name="limit">
                    <option value="25" {{!isset($limit) || $limit=="25"?'selected="selected"':''}}>25</option>
                    <option value="50" {{isset($limit) && $limit=="50"?'selected="selected"':''}}>50</option>
                    <option value="100" {{isset($limit) && $limit=="100"?'selected="selected"':''}}>100</option>
                </select>
            </div>
            <div class="col-5 float-right input-group d-none d-md-flex">
                <input type="text" class="form-control form-control-sm" id="search" name="search" placeholder="Buscar..." aria-label="Buscar..." value="{{$search??''}}" />
                <div class="input-group-append">
                    <button class="btn btn-primary btn-sm float-right" type="button" onclick="searchBarClick()"><i class="fas fa fa-search"></i></button>
                </div>
            </div>
        </h4>
    </div>
</div>

@includeFirst(['filters', 'framework::filters'])

<div class="row">
    <div class="col-12" style="overflow: auto;">
        @includeFirst(['list', 'framework::list'])
    </div>
</div>

@includeFirst(['search', 'framework::search'])
<script type="text/javascript">
    var deleteTitle = '{{$deleteTitle??"Confirmar eliminar Registro"}}';
    var deleteMessage = '{{$deleteMessage??"¿Está seguro que desea eliminar el registro?"}}';
    var deleteConfirmClass = '{{$deleteConfirmClass??"btn btn-danger btn-icon-split ml-2"}}';
    var deleteCancelClass = '{{$deleteCancelClass??"btn btn-secondary btn-icon-split"}}';
    var deleteCancelText = '{{$deleteCancelText??"Cancelar"}}';
    var deleteConfirmText = '{{$deleteConfirmText??"¡Si, eliminar!"}}';
</script>
@endsection

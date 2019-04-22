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
@if (\Session::has('error'))
<div class="alert alert-danger">
    <strong><i class="fas fa-exclamation-circle"></i> Error:</strong> {{ \Session::get('error') }}
</div>
@endif

@includeFirst(['sections.breadcrumb', 'framework::sections.breadcrumb'])

<div class="row">
    <div class="col-12">
        <h4 class="pb-2 mb-2 border-bottom">
            {{isset($title) ? $title : 'Listado'}}
            @foreach ($data['actions'] as $action)
            @if (isset($action["global"]) && $action["global"] && is_authorized($controller,$action["action"]))
            <a href="{{fmw_action($controller, $action['action'])}}" class="btn btn-sm btn-primary btn-icon-split">
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
                    @if(class_exists(str_replace(["Controller","\\Http"],["Export", ""],$controller)))
                    <div id="export" style="display: none;"></div>
                    <a href="javascript:void(0);" class="btn btn-light btn-sm" onclick="exportClick('xls')">
                        <i class="fa fa-file-excel" data-toggle="tooltip" data-placement="top" title="Descargar XLS" ></i>
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
            <div class="col-4 float-right input-group d-none d-md-flex">
                <input type="text" class="form-control form-control-sm" id="search" name="search" placeholder="Buscar..." aria-label="Buscar..." value="@if(!empty($search)){{$search}}@endif" />
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
    var deleteMessage = '{{$deleteMessage??"¿Está seguro que desea eliminar el registro?"}}';
</script>
@endsection

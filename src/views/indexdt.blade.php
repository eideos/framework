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
            @php $controllerAction = $action['controller'] ?? $controller @endphp
            @if (isset($action["global"]) && $action["global"] && is_authorized($controllerAction, $action["action"]))
            <a href="{{fmw_action($controllerAction, $action['action'])}}" class="btn btn-sm {{$action['class']??'btn-primary'}} btn-icon-split">
              <span class="icon text-white">
                <i class="fas fa-{{$action["icon"]}}"></i>
              </span>
              <span class="text">{{$action["label"]}}</span>
            </a>
            @endif
            @endforeach
            <a href="#collapseRowForm" class="mr-3 mt-2 h6" style="float: right;" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseRowForm">
            <a id="filtros[{{$model}}]" href="#collapseRowForm" class="mr-3 mt-2 h6" style="float: right; text-decoration: none" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseRowForm">
                Filtros<i class="fas fa-angle-down text-secondary ml-3"></i>
            </a>
        </h4>
    </div>
</div>

<div class="row mt-2">
    <div class="col-12">
        @includeFirst(['searchdt', 'framework::searchdt'])
    </div>
</div>

@includeFirst(['filters', 'framework::filters'])

<div class="row mt-2">
    <div class="col-12">
        @includeFirst(['listdt', 'framework::listdt'])
    </div>
</div>

<script>
    var dataTableSettings = {!!(json_encode($datatable['params'])??[])!!}
    $(function() {
        $("#{{class_basename($model)}}").DataTable(
            dataTableSettings
        );
    } );
</script>

<script type="text/javascript">
    var deleteTitle = '{{$deleteTitle??"Confirmar eliminar Registro"}}';
    var deleteMessage = '{{$deleteMessage??"¿Está seguro que desea eliminar el registro?"}}';
    var deleteConfirmClass = '{{$deleteConfirmClass??"btn btn-danger btn-icon-split ml-2"}}';
    var deleteCancelClass = '{{$deleteCancelClass??"btn btn-secondary btn-icon-split"}}';
    var deleteCancelText = '{{$deleteCancelText??"Cancelar"}}';
    var deleteConfirmText = '{{$deleteConfirmText??"¡Si, eliminar!"}}';
</script>
@endsection

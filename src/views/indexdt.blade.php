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
            @if (isset($action["global"]) && $action["global"] && is_authorized($controller,$action["action"]))
            <a href="{{fmw_action($controller, $action['action'])}}" class="btn btn-sm btn-primary btn-icon-split">
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

@includeFirst(['searchdt', 'framework::searchdt'])

@includeFirst(['filters', 'framework::filters'])

<div class="row mt-2">
    <div class="col-12">
        @includeFirst(['listdt', 'framework::listdt'])
    </div>
</div>


<script type="text/javascript">
    var deleteMessage = '{{$deleteMessage??"¿Está seguro que desea eliminar el registro?"}}';
</script>
@endsection

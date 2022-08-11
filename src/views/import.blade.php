@extends($layout)

@section('title', isset($title) ? $title : '')

@section('content')

<script type="text/javascript">
    var OP = "A";
</script>

@foreach($cssincludes as $cssfile)
<link rel="stylesheet" href="{{ URL::asset($cssfile) }}" />
@endforeach

@if ($errors->any())
<div class="alert alert-danger">
    <strong><i class="fas fa-exclamation-circle"></i> Error:</strong> Por favor corrige los errores del formulario.
</div>
@endif

@if (!empty($warning))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong><i class="fas fa-exclamation-triangle"></i> Advertencia:</strong>{!! $warning !!}
</div>
@endif

@if (!empty($info))
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <strong><i class="fas fa-info-circle"></i> Información:</strong> {!! $info !!}
</div>
@endif

@includeFirst(['sections.breadcrumb', 'framework::sections.breadcrumb'])

<div class="row">
    <div class="col-12">
        <form method="post" class="maint" action="{{fmw_action($controller, 'import')}}" enctype="multipart/form-data" data-type="maint">
            @csrf
            <input name="_url" type="hidden" value="{{$url}}">

            <div class="row">
                <div class="col-md-12 mb-3" id="block[import]">
                    <h5 class="mb-3 font-weight-bold">Importación</h5>
                    <div class="row">
                        <input type="file" name="import_file" class="form-control">
                    </div>
                </div>
            </div>

            <div class="mb-3 mt-2 float-right maint-actions">
                <a href="{{url("/" . $url)}}?_last=1" id="cancelButton" class="btn btn-light btn-icon-split">
                    <span class="icon text-white">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                    <span class="text">{{env('LABEL_VOLVER', 'Volver')}}</span>
                </a>
                <button type="submit" class="btn btn-success btn-icon-split ml-2">
                    <span class="icon text-white">
                        <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Guardar</span>
                </button>
            </div>
        </form>
    </div>
</div>
{!! $validator !!}

@foreach($jsincludes as $jsfile)
<script type="text/javascript" src="{{ URL::asset($jsfile) }}"></script>
@endforeach

@endsection
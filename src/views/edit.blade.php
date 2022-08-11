@extends($layout)

@section('title', isset($title) ? $title : '')

@section('content')

<script type="text/javascript">var OP = "E";</script>

@foreach($cssincludes as $cssfile)
<link rel="stylesheet" href="{{ URL::asset($cssfile) }}" />
@endforeach

@includeFirst(['sections.heartbeat', 'framework::sections.heartbeat'])

@if ($errors->any())
<div class="alert alert-danger">
  <strong><i class="fas fa-exclamation-circle"></i> Error:</strong> Por favor corrige los errores del formulario.
</div>
@endif

@if (!empty($warning))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong><i class="fas fa-exclamation-triangle"></i> Advertencia:</strong> {!! $warning!!}  
</div>
@endif

@if (!empty($info))
<div class="alert alert-info alert-dismissible fade show" role="alert">
  <strong><i class="fas fa-info-circle"></i> Información:</strong> {{! $info !}}
</div>
@endif

@includeFirst(['sections.breadcrumb', 'framework::sections.breadcrumb'])

<div class="row">
    <div class="col-12">
        <form method="post" class="maint" action="{{fmw_action($controller, 'update', $id)}}" enctype="multipart/form-data" data-type="maint">
            @csrf
            <input name="_method" type="hidden" value="PATCH">
            <input name="_maint" type="hidden" value="{{$maintfile}}">
            <input name="_url" type="hidden" value="{{$url}}">
            <input name="_popup" type="hidden" value="{{$popup}}">

            @includeFirst(['form', 'framework::form'])

            <div class="mb-3 mt-2 float-right maint-actions">
              @if($popup)
              <a onclick="parent.$.fancybox.close()" id="cancelButton" class="btn btn-light btn-icon-split">
                <span class="icon text-white">
                  <i class="fas fa-chevron-left"></i>
                </span>
                <span class="text">{{env('LABEL_VOLVER', 'Volver')}}</span>
              </a>
              @else
            <a href="{{url("/" . $url)}}?_last=1&_free={{$id}}" id="cancelButton" class="btn btn-light btn-icon-split">
                <span class="icon text-white">
                  <i class="fas fa-chevron-left"></i>
                </span>
                <span class="text">{{env('LABEL_VOLVER', 'Volver')}}</span>
              </a>
              @endif
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

@foreach ($maint as $tab => $tabData)
      @foreach ($tabData["blocks"] as $keyBlock => $block)
            @if (in_array($block["type"], ["table", "tablepopup"]))
              @includeFirst(['sections.tableadd', 'framework::sections.tableadd'], array_merge($block, [
                'readonly' => $readonly ?? false,
                'actions' => $block["actions"] ?? ["add"=>true, "update"=>true, "delete"=>true],
                ]))
            @endif
            @php $first = false; @endphp
      @endforeach
@endforeach

@foreach($jsincludes as $jsfile)
<script type="text/javascript" src="{{ URL::asset($jsfile) }}"></script>
@endforeach

@endsection

@extends($layout)

@section('title', isset($title) ? $title : '')

@section('content')

@include('framework::sections.jsvars')
<script type="text/javascript">var OP = "V";</script>

@foreach($cssincludes as $cssfile)
<link rel="stylesheet" href="{{ URL::asset($cssfile) }}" />
@endforeach

@if (!empty($warning))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong><i class="fas fa-exclamation-triangle"></i> Advertencia:</strong> {!! $warning !!}
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
        @includeFirst(['form', 'framework::form'], ['readonly'=>true])

        <div class="mb-3 mt-2 float-right maint-actions">
          @if($popup)
          <a onclick="parent.$.fancybox.close()" id="cancelButton" class="btn btn-light btn-icon-split">
            <span class="icon text-white">
              <i class="fas fa-chevron-left"></i>
            </span>
            <span class="text">{{env('LABEL_VOLVER', 'Volver')}}</span>
          </a>
          @else
          <a href="{{url("/" . $url)}}?_last=1" id="cancelButton" class="btn btn-light btn-icon-split">
            <span class="icon text-white">
              <i class="fas fa-chevron-left"></i>
            </span>
            <span class="text">{{env('LABEL_VOLVER', 'Volver')}}</span>
          </a>
          @endif
        </div>
    </div>
</div>

@foreach ($maint as $tab => $tabData)
  @foreach ($tabData["blocks"] as $keyBlock => $block)
    @if (in_array($block["type"], ["table", "tablepopup"]))
      @if (!isset($block["actions"]['show']) || $block["actions"]['show'])
        @includeFirst(['sections.tableshow', 'framework::sections.tableshow'], array_merge($block, [
        'readonly' => $readonly ?? true,
        'actions' => $block["actions"] ?? ["add"=>false, "update"=>false, "delete"=>false, "show" => true],
        ]))
      @endif
    @endif
    @php $first = false; @endphp
  @endforeach
@endforeach

@foreach($jsincludes as $jsfile)
<script type="text/javascript" src="{{ URL::asset($jsfile) }}"></script>
@endforeach

@endsection

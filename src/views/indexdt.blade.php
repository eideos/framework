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

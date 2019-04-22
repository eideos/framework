@extends('framework::layouts.app')

@section('title', 'Inicio')
@php $model = ""; $displayButtons = get_buttons();@endphp

@section('content')

@if (\Session::has('success'))
<div class="alert alert-success">
  <strong><i class="fas fa-check-circle"></i> Correcto:</strong> {{ \Session::get('success') }}
</div>
@endif
@if (\Session::has('danger'))
<div class="alert alert-danger">
  <strong><i class="fas fa-exclamation-circle"></i> Alerta:</strong> {{ \Session::get('danger') }}
</div>
@endif

<div class="row d-none d-md-flex">
  <div class="col-lg-10 offset-lg-1">
    <div class="row">
        @foreach ($displayButtons as $displayButton)
          <a class="home-shortcut col-lg-3 col-4" href="{{url($displayButton["url"])}}">
              <span class="rounded-circle bg-{{$displayButton["color"]??"primary"}}">
                  <i class="fa fa-{{$displayButton["icon"]}}"></i>
              </span>
              <h4>{{$displayButton["name"]}}</h4>
          </a>
      @endforeach
    </div>
  </div>
</div>

<div class="row d-block d-md-none">
  <div class="col-12">
    @foreach ($displayButtons as $displayButton)
    <a class="home-shortcut-sm" href="{{url($displayButton["url"])}}">
      <div class="alert bg-secondary">
        <h4 class="mb-0 text-white"><i class="fa fa-{{$displayButton["icon"]}}"></i> {{$displayButton["name"]}}</h4>
      </div>
    </a>
    @endforeach
  </div>
</div>


@endsection

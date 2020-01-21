@extends('framework::layouts.presentation')

@section($name)
<div class="form-group col-md-{{$cols or "12"}}">
    <input type="hidden" name="{{$name}}" value="{{old($name, $value??$initialvalue??'')}}" />
    <label for="{{$name}}">{{$label}}</label>
    <div id="mapa{{$name}}" style="width: 400px; height: 300px;"></div>
    <div class="mt-2">
        <a href="javascript:void(0);" onclick="googlemap['{{$name}}'].geolocate();" id="gmap_geolocate_{{$name}}" class="btn btn-secondary btn-sm"><i class="fa fa-map-marker-alt"></i> Georeferenciar</a>
        <a href="javascript:void(0);" onclick="googlemap['{{$name}}'].restart();" id="gmap_restart_{{$name}}" class="btn btn-secondary btn-sm"><i class="fa fa-edit"></i> Cambiar Dirección</a>
    </div>
</div>
@endsection

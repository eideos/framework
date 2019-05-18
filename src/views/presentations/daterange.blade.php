@extends('framework::layouts.presentation')

@section($name)
<div class="form-group col-md-{{$cols or "12"}}">
    @if(!isset($table)||!$table)
    <label for="{{$name}}">{{$label}}</label>
    @endif
    <input type="hidden" name="{{$name}}" value="{{old($name, $value??$initialvalue??'')}}" />
    <div class="row">
        <div class="col-md-6">
            <input type="text" name="{{$name}}[from]" autocomplete="off" value="{{old($name . "[from]", $value_from??'')}}" class="form-control" />
        </div>
        <div class="col-md-6">
            <input type="text" name="{{$name}}[to]" autocomplete="off" value="{{old($name . "[to]", $value_to??'')}}" class="form-control" />
        </div>
    </div>
    @if(!empty($note)) <small id="{{$name}}_note" class="text-muted">{{$note}}</small> @endif
</div>
@endsection

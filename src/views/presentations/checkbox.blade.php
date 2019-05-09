@extends('framework::layouts.presentation')

@section($name)
<div class="form-group col-md-{{$cols or "12"}}">
    @if(!isset($table)||!$table)
    <label for="{{$name}}">{{$label}}</label>
    @endif
    <div>
        @foreach ($options as $key => $option)
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="{{$name}}[]" value="{{$key}}" {{in_array($key, old($name, $values??''))?'checked="checked"':''}} data-validation-name="{{get_validation_field_name($name)}}" id="{{$name.$key}}">
            <label class="form-check-label" for="{{$name.$key}}">{!! $option !!}</label>
        </div>
        @endforeach
    </div>
    @if($errors->has(get_validation_field_name($name)))
    <div class="invalid-feedback">
        @foreach($errors->get(get_validation_field_name($name)) as $error)
        {{$error}}
        @endforeach
    </div>
    @endif
</div>
@endsection

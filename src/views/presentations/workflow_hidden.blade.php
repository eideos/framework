@extends('framework::layouts.presentation')

@section($name)
<div class="form-group col-md-{{$cols or "12"}}" style="display: none;">
    @if(!isset($table)||!$table)
    <label for="{{$name}}">{{$label}}</label>
    @endif
    <select name="{{$name}}"
            data-validation-name="{{get_validation_field_name($name)}}"
            data-previous-value="{{$value}}"
            class="form-control {{isset($table)&&$table?'form-control-sm':''}} {{is_required_field($name,$required_fields??[])?'required':''}} {{$errors->has(get_validation_field_name($name))?'is-invalid':''}}">
        <option value="" />
        @if(isset($options) && is_array($options))
        @foreach($options as $option)
        <option data-order="{{$option['order']??0}}" value="{{$option['step']}}" @if((string)old($name, $value??$initialvalue??'')===(string)$option['step']) selected @endif>{{$option['label']}}</option>
        @endforeach
        @endif
    </select>
    @if($errors->has(get_validation_field_name($name)))
    <div class="invalid-feedback">
        @foreach($errors->get(get_validation_field_name($name)) as $error)
        {{$error}}
        @endforeach
    </div>
    @endif
    @if(!empty($note)) <small id="{{$name}}_note" class="text-muted">{{$note}}</small> @endif
</div>
@endsection

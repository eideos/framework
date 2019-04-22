@extends('framework::layouts.presentation')

@section($name)
<div class="form-group col-md-{{$cols or "12"}}">
    @if(!isset($table)||!$table)
    <label for="{{$name}}">{{$label}}</label>
    @endif
    <div class="input-group mb-2">
        <div class="input-group-prepend">
            <span class="input-group-text" id="{{$name}}-salary-addon"><small>123</small></span>
        </div>
    <input type="number"
           name="{{$name}}"
           data-validation-name="{{get_validation_field_name($name)}}"
           value="{{old($name, $value??$initialvalue??'')}}"
           @if(isset($readonly)&&$readonly) disabled @endif
           class="form-control {{isset($table)&&$table?'form-control-sm':''}} {{is_required_field($name,$required_fields??[])?'required':''}} {{$errors->has(get_validation_field_name($name))?'is-invalid':''}} {{$class??''}}"
           />
           </div>
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

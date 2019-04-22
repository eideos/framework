@extends('framework::layouts.presentation')

@section($name)
<div class="form-group col-md-{{$cols or "12"}}">
    @if((!isset($table)||!$table)&&(!isset($list)||!$list))
    <label for="{{$name}}">{{$label}}</label>
    @endif
    <input type="text"
           name="{{$name}}"
           data-validation-name="{{get_validation_field_name($name)}}"
           value="{{old($name, $value??$initialvalue??'')}}"
           @if(!empty($placeholder)) placeholder="{{$placeholder}}" @endif
           class="form-control {{isset($table)&&$table?'form-control-sm':''}} {{is_required_field($name,$required_fields??[])?'required':''}} {{$errors->has(get_validation_field_name($name))?'is-invalid':''}} {{$class??''}}"
           />
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

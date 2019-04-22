@extends('framework::layouts.presentation')

@section($name)
@php $value = empty($value) ? "" : \App\Presentations\Date::getDisplayValue($value); @endphp
<div class="form-group col-md-{{$cols or "12"}}">
    @if(!isset($table)||!$table)
    <label for="{{$name}}">{{$label}}</label>
    @endif
    <input type='hidden' name='{{$name}}' value='{{(string)old($name, $value ?? '')}}' />
    @if(isset($readonly)&&$readonly)
    <div class="val">{{old($name, $value??$initialvalue??'')}}</div>
    @else
    <input type="text"
           name="tmp_{{$name}}_from"
           autocomplete="off"
           value="{{old($name, $value??$initialvalue??'')}}"
           @if(isset($readonly)&&$readonly) disabled @endif
           class="form-control {{isset($table)&&$table?'form-control-sm':''}} {{is_required_field($name,$required_fields??[])?'required':''}} {{$errors->has($name)?'is-invalid':''}}"
           />
           <input type="text"
           name="tmp_{{$name}}_to"
           autocomplete="off"
           value="{{old($name, $value??$initialvalue??'')}}"
           @if(isset($readonly)&&$readonly) disabled @endif
           class="form-control {{isset($table)&&$table?'form-control-sm':''}} {{is_required_field($name,$required_fields??[])?'required':''}} {{$errors->has($name)?'is-invalid':''}}"
           />
           @endif
           @if($errors->has($name))
           <div class="invalid-feedback">
               @foreach($errors->get($name) as $error)
               {{$error}}
               @endforeach
           </div>
           @endif
           @if(!empty($note)) <small id="{{$name}}_note" class="text-muted">{{$note}}</small> @endif
</div>
@endsection

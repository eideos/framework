@extends('framework::layouts.presentation')

@section($name)
<div class="form-group col-md-{{$cols ?? 12}}">
    @if((!isset($table) || !$table) && (!isset($list)||!$list))
    <label for="{{$name}}">{{$label}}</label>
    @endif
    <textarea type="text" name="{{$name}}" readonly class="form-control {{isset($table) && $table ? 'form-control-sm' : ''}} {{$class??''}}">{{old($name, $value ?? $initialvalue??'')}}</textarea>
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

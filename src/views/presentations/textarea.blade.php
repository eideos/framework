@extends('framework::layouts.presentation')

@section($name)
<div class="form-group col-md-{{$cols ?? 12}}">
    @if(!isset($table)||!$table)
    <label for="{{$name}}">{{$label}}</label>
    @endif
    <textarea name="{{$name}}" rows="{{isset($rows) ? $rows : 2}}" class="form-control {{isset($table) && $table ? 'form-control-sm' : ''}} {{is_required_field($name,$required_fields ?? []) ? 'required' : ''}} {{$errors->has($name) ? 'is-invalid' : ''}}">{{old($name, $value ?? $initialvalue ?? '')}}</textarea>
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

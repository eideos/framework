@extends('framework::layouts.presentation')

@section($name)
<div class="form-group col-md-{{$cols ?? "12"}}">
    @if(!isset($table)||!$table)
    <label for="{{$name}}">{{$label}}</label>
    @endif
    <select name="{{$name}}"
            data-validation-name="{{get_validation_field_name($name)}}"
            @if(isset($readonly)&&$readonly) disabled @endif
            @if(isset($uniqueInTable)) data-unique-table="{{$uniqueInTable}}" @endif
            class="form-control {{isset($table)&&$table?'form-control-sm':''}} {{is_required_field($name,$required_fields??[])?'required':''}} {{$errors->has(get_validation_field_name($name))?'is-invalid':''}}">
            <option value="" />
        @if(isset($options) && is_array($options))
        @foreach($options as $option => $optionLabel)
        <option value="{{$option}}" @if((string)old($name, $value??$initialvalue??'')===(string)$option) selected @endif>{{$optionLabel}}</option>
        @endforeach
        @endif
    </select>
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

@extends('framework::layouts.presentation')

@section($name)
<div class="form-group col-md-{{$cols ?? "12"}}">
    @if(!isset($table)||!$table)
    <label for="{{$name}}">{{$label}}</label>
    @endif
    <!--<a class="btn btn-primary btn-xs" href="javascript:void(0);" onclick="addPopupForm();">&nbsp;+&nbsp;</a>-->
    <select name="{{$name}}"
            data-model="{{$model}}"
            data-searchfield="{{$displayField ? $displayField : 'id'}}"
            data-displayfield="{{$displayField ?? "id"}}"
            data-validation-name="{{get_validation_field_name($name)}}"
            @if(isset($listen)) data-listen="{{$listen}}" @endif
            @if(isset($listenCallback)) data-listen-callback="{{$listenCallback}}" @endif
            @if(isset($uniqueInTable)) data-unique-table="{{$uniqueInTable}}" @endif
            @if(isset($readonly)&&$readonly) disabled @endif
            class="form-control {{isset($table)&&$table?'form-control-sm':''}} {{is_required_field($name,$required_fields??[])?'required':''}} {{$errors->has(get_validation_field_name($name))?'is-invalid':''}}">
            <option value="" />
        @foreach($options as $option => $optionLabel)
        <option value="{{$option}}" @if((string)old($name, $value??$initialvalue??'')===(string)$option) selected @endif>{{$optionLabel}}</option>
        @endforeach
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

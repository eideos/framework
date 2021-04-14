@extends('framework::layouts.presentation')

@section($name)
<div class="form-group col-md-{{$cols ?? "12"}}">
    @if((!isset($table)||!$table)&&(!isset($list)||!$list))
    <label for="{{$name}}">{{$label}}</label>
    @endif
    @if(isset_notempty($symbol))
    <div class="input-group mb-2">
        <div class="input-group-prepend">
            <span class="input-group-text" id="{{$name}}-salary-addon">{{$symbol??"$"}}</span>
        </div>
        @endif
        <input type="hidden" name="{{$name}}" value="{{old($name, $value??$initialvalue??'')}}" />
        <input type="text"
               name="{{$name}}_ro"
               style="text-align: right;"
               readonly aria-invalid="false"
               data-validation-name="{{get_validation_field_name($name)}}"
               value="{{old($name, $helperValue??$initialvalue??'')}}"
               @if(isset($readonly)&&$readonly) disabled @endif
               class="form-control {{isset($table)&&$table?'form-control-sm':''}} {{$errors->has(get_validation_field_name($name))?'is-invalid':''}} {{$class??''}}"
               />
               @if(isset_notempty($symbol))
    </div>
    @endif
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

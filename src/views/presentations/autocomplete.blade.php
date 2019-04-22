@extends('framework::layouts.presentation')

@section($name)
<div class="form-group col-md-{{$cols or "12"}}">
    @if(!isset($table)||!$table)
    <label for="{{$name}}">{{$label}}</label>
    @endif
    <!--<a class="btn btn-primary btn-xs" href="javascript:void(0);" onclick="addPopupForm();">&nbsp;+&nbsp;</a>-->
    <div class="input-group">
        <input type="text"
               autocomplete="off"
               data-autocomplete="1"
               name="{{$name}}_ac"
               value="{{old($name."_ac", $helperValue)}}"
               @if(!empty($placeholder)) placeholder="{{$placeholder}}" @endif
               class="form-control {{isset($table) && $table ? 'form-control-sm' : ''}} {{is_required_field($name,$required_fields ?? []) ? 'required' : ''}} {{$errors->has(get_validation_field_name($name)) ? 'is-invalid' : ''}}"
               />
        <input type="hidden"
               name="{{$name}}"
               value="{{old($name, $value??$initialvalue??'')}}"
               data-model="{{$model}}"
               data-displayfield="{{$displayField ?? "id"}}"
               @if(isset($listen)) data-listen="{{$listen}}" @endif
               @if(isset($listenCallback)) data-listen-callback="{{$listenCallback}}" @endif
               class="form-control {{isset($table) && $table ? 'form-control-sm' : ''}} {{is_required_field($name,$required_fields ?? []) ? 'required' : ''}} {{$errors->has($name) ? 'is-invalid' : ''}}"
               />
               <div class="input-group-append">
            <div class="input-group-text"><i class="fas fa-list-ul"></i></div>
            @if($addButton)
            <div class="input-group-text">
                <a href='{{fmw_action($controller , 'create')}}' target="_blank">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
            @endif
        </div>
    </div>
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

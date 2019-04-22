@extends('framework::layouts.presentation')

@section($name)
<div class="form-group col-md-{{$cols or "12"}}">
    @if((!isset($table)||!$table)&&$label!==false)
    <label for="{{$name}}">{{$label}}</label>
    @endif
    @if(isset($readonly)&&$readonly)
    <input type='hidden' name='{{$name}}' value='{{(string)old($name, $value ?? '')}}' />
    <div class="val">{{old($name, $value??$initialvalue??'')}}</div>
    @else
    <input type="text"
           name="{{$name}}"
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

@section('js_' . $name)
@if(!isset($readonly) || !$readonly)
<script>
    $(function () {
        $('[name="{{$name}}"]').timepicker({
            uiLibrary: 'bootstrap4',
            format: 'H:MM'
        });
    });
</script>
@endif
@endsection

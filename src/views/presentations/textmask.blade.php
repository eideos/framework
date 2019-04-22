@extends('framework::layouts.presentation')

@section($name)
<div class="form-group col-md-{{$cols or "12"}}">
    @if(!isset($table)||!$table)
    <label for="{{$name}}">{{$label}}</label>
    @endif
    <input type="text"
           name="{{$name}}"
           id="{{$name or "mask"}}"
           value="{{old($name, $value??$initialvalue??'')}}"
           @if(isset($readonly)&&$readonly) disabled @endif
           class="form-control {{isset($table)&&$table?'form-control-sm':''}} {{is_required_field($name,$required_fields??[])?'required':''}} {{$errors->has($name)?'is-invalid':''}}"
           />
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
<script type="text/javascript">
    $(function () {
        $('#{{$name or "mask"}}').mask("{{$mask}}", {reverse: true});
    });
</script>
@endsection

@extends('framework::layouts.presentation')

@section($name)
<div class="form-group col-md-{{$cols or "4"}}">
    @if((!isset($table)||!$table)&&(!isset($list)||!$list))
    <label for="{{$name}}">{{$label}}</label>
    @endif
    <input type="hidden" id="{{$name or "avatar"}}" name="{{$name or "avatar"}}" value="{{old($name, $value??$initialvalue??'')}}" />
    <input type="file" id="{{$name or "avatar"}}File" name="{{$name or "avatar"}}_file{{$multiple?"[]":""}}"
           value="{{old($name, $value??$initialvalue??'')}}"
           data-theme="{{$theme or "fas"}}"
           data-default-preview-content="{{files_preview_html($value??"")}}"
           data-max-file-size="{{$maxFileSize or "1500"}}"
           {{$multiple?"multiple":""}}
           />
           @if(!empty($force_delete) && $force_delete)<button id="{{$name}}_delete" type="button" tabindex="500" title="Quitar archivos seleccionados" class="btn btn-default btn-secondary fileinput-remove fileinput-remove-button fileinput-initial-delete" style="display:none; position: relative; top: -37px; left: 50px;"><i class="fas fa-trash-alt"></i></button>@endif
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

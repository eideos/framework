@extends('framework::layouts.presentation')
@section($name)
<div class="form-group col-md-{{$cols ?? "12"}}">
    <input type="hidden" name="{{$name}}" value="{{old($name, $value??$initialvalue??'')}}" />
    <div class="file-preview-thumbnails">
        <div class="file-default-preview" id="{{$name}}Preview">
            {!! files_preview_html($value??'') !!}
        </div>
    </div>
</div>
@endsection
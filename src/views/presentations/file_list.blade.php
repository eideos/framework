@extends('framework::layouts.presentation')
@section($name)
<div class="form-group col-md-{{$cols or "12"}}">
    <input type="hidden" name="{{$name}}" value="{{old($name, $value??$initialvalue??'')}}" />
    <div class="file-preview-thumbnails">
        <div class="file-default-preview">
            {!! files_preview_html($value) !!}
        </div>
    </div>
</div>
@endsection
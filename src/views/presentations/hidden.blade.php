<input type="hidden" name="{{$name}}" value="{{old($name, $value??$initialvalue??'')}}" />
@if(isset($showText) && $showText)
<div>{{old($name, $value??$initialvalue??'')}}</div>
@endif
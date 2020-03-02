<input type="hidden" name="{{$name}}" value="{{old($name, $value??'')}}" />
<div class="val {{$class??''}}" style="text-align: right;">{!! $helperValue??'' !!}</div>
@if(isset($note)&&!empty($note))
<a id="{{$name}}Note"><small>{{$note}}</small></a>   
@endif

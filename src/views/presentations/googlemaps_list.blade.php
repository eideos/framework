<input type="hidden" name="{{$name}}" value="{{old($name, $value??$initialvalue??'')}}" />
<div class="val">
    @if (empty($value))
    Sin geolocalizar
    @else
    <a data-fancybox="" data-options="{&quot;iframe&quot; : {&quot;css&quot; : {&quot;width&quot; : &quot;80%&quot;, &quot;height&quot; : &quot;80%&quot;}}}" href="https://www.google.com/maps/search/?api=1&amp;query={{str_replace(" ", "+", $value)}}" class="btn btn-sm btn-secondary"><i class='fa fa-map-marker-alt'></i></a>
    @endif
</div>

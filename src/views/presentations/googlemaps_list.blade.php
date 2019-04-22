<input type="hidden" name="{{$name}}" value="{{old($name, $value??$initialvalue??'')}}" />
<div class="val">
    @if (empty($value))
    Sin geolocalizar
    @else
    <a class='btn btn-inverse btn-sm fancybox fancybox.iframe' data-toggle='tooltip' href='http://maps.google.com/?output=embed&q=loc:{{str_replace(" ", "+", $value)}}' title='Link a Mapa' target='_blank'>
        <i class='fa fa-map-marker-alt'></i>
    </a>
    @endif
</div>

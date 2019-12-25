<div class="form-group col-md-{{$cols or "12"}}">
    <input type="hidden" name="{{$name}}" value="{{old($name, $value??$initialvalue??'')}}" />
    <label for="{{$name}}">{{$label}}</label>
    @if (!empty($value))
    <div>
        <img src="http://maps.google.com/maps/api/staticmap?key={{env('GOOGLEMAPS_KEY', '')}}&center={{$value}}&zoom=16&size=400x300&maptype=roadmap&markers={{$value}}" />
    </div>
    @endif
</div>

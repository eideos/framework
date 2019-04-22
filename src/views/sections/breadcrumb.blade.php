@if (isset($breadcrumb))
<ol class="breadcrumb">
    @foreach ($breadcrumb as $item)
    <li class="breadcrumb-item {{isset($item["active"]) && $item["active"] ? "active" : ""}}">
        @if (!empty($item["url"]))
        <a href="{{url($item["url"])}}">{{$item["label"]}}</a>
        @else
        {{$item["label"]}}
        @endif
    </li>
    @endforeach
</ol>
@endif
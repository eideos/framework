@include('framework::sections.alert')
@php $grouptabs = []; @endphp

@foreach ($maint as $item => $itemData)
@if($itemData['type']=="block")
@php $tabData = $itemData; @endphp
@includeFirst(['block', 'framework::block'])
@endif

@if($itemData['type']=="tab" && !in_array($itemData['group'], $grouptabs))
@php $grouptabs[] = $itemData['group']; @endphp
<ul class="nav nav-tabs mb-4 {{count($maint)==1?'d-none':''}}" role="tablist">
    @php $first=true; @endphp
    @foreach ($maint as $tab => $tabData)
    @if($tabData['type']=="tab" && $itemData['group'] == $tabData['group'])
    <li class="nav-item">
        <a class="nav-link{{$first?" active":""}}" id="{{$tab}}-tab" data-toggle="tab" href="#{{$tab}}" role="tab" aria-controls="home" aria-selected={{$first}}>
            @if(isset($tabData['icon']))
            <i class="fas fa-{{$tabData['icon']}}"></i>
            @endif
            {{$tabData["label"]}}
            <span class="badge badge-danger"></span>
        </a>
    </li>
    @php $first = false; @endphp
    @endif

    @endforeach
</ul>

<div class="tab-content">
    @php $first=true; @endphp
    @foreach ($maint as $tab => $tabData)
    @if($tabData['type']=="tab" && $itemData['group'] == $tabData['group'])
    <div class="tab-pane fade{{$first?" show active":""}}" id="{{$tab}}" role="tabpanel" aria-labelledby="{{$tab}}-tab">
        @includeFirst(['block', 'framework::block'])
    </div>
    @php $first = false; @endphp
    @endif
    @endforeach
</div>
@endif

@endforeach


<script type="text/javascript">
    $(function() {
        var formInits = @json($form_inits['form'] ?? []);
        for (var i in formInits) {
            eval(formInits[i]);
        }
    });
</script>
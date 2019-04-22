@include('framework::sections.alert')

<ul class="nav nav-tabs mb-4 {{count($maint)==1?'d-none':''}}" role="tablist">
    @php $first=true; @endphp
    @foreach ($maint as $tab => $tabData)
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
    @endforeach
</ul>

<div class="tab-content">
    @php $first=true; @endphp
    @foreach ($maint as $tab => $tabData)
    <div class="tab-pane fade{{$first?" show active":""}}" id="{{$tab}}" role="tabpanel" aria-labelledby="{{$tab}}-tab">
        <div class="row">
            @foreach ($tabData["blocks"] as $keyBlock => $block)
            @if (isset($block["label"])&&!in_array($block["type"], ["table", "tablepopup", "files"]))
            @endif
            <div class="col-md-{{$block["cols"]??12}} mb-3" id="block[{{$block['id']??$keyBlock}}]">
                @if ($block["type"] == "fieldset")
                @if (!empty($block["label"]))
                <h5 class="mb-3 font-weight-bold">{{$block["label"]}}</h5>
                @endif
                <div class="row">
                    @foreach ($block["fields"] as $maintfield)
                    @include($maintfield->getViewFieldPath(), ((isset($block["readonly"]) && $block["readonly"]) ?  array_merge($maintfield->getViewVars(), ["readonly" => true]) : $maintfield->getViewVars()))
                    @endforeach
                </div>
                @elseif (in_array($block["type"], ["table", "tablepopup"]))
                <div class="row">
                    @include('framework::sections.' . $block["type"], array_merge($block, [
                    'readonly' => $readonly ?? false,
                    'actions' => $block["actions"] ?? ["add"=>true, "update"=>true, "delete"=>true],
                    ]))
                </div>
                @endif
                @if ($block["type"] == "files")
                <div class="row">
                    @include('framework::sections.' . $block["type"], array_merge($block, [
                    'readonly' => $readonly ?? $block["readonly"] ?? false,
                    'labels' => ['add' => 'Agregar', 'delete' => 'Borrar'],
                    'actions' => $block["actions"] ?? ["add"=>true, "update"=>true, "delete"=>true],
                    ]))
                </div>
                @endif
            </div>
            @php $first = false; @endphp
            @endforeach
        </div>
    </div>
    @endforeach
</div>

<script type="text/javascript">
    $(function () {
        var formInits = @json($form_inits['form'] ?? []);
                for (var i in formInits) {
            eval(formInits[i]);
        }
    });
</script>

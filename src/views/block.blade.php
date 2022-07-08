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
            @if(is_null($maintfield->actions) || in_array($op, explode("|", $maintfield->actions)))
            @include($maintfield->getViewFieldPath(), ((isset($block["readonly"]) && $block["readonly"]) ? array_merge($maintfield->getViewVars(), ["readonly" => true]) : $maintfield->getViewVars()))
            @endif
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
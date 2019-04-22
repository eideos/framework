@if (count($filters))
  <div class="row">
    <div class="col-12">
      <div class="border-bottom pb-2">
        <div class="float-left mr-1"><i class="fas fa-filter"></i></div>
        @foreach ($filters as $filterName => $filterLabelValue)
        <div class="float-left mr-2"><strong>{{$filterLabelValue[0]}}:</strong> {!! $filterLabelValue[1] !!}</div>
        @endforeach
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
@endif

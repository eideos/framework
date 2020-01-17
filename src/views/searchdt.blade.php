<div class="row border-bottom mb-2">
  <div class="col-lg-12">
    <!-- Filtros de Búsqueda -->
    <div class="mb-4">
      <form method="get" action="{{url($url)}}" data-type="search">
        <div class="row">
            @foreach ($searchfields as $searchfield)
            @include($searchfield->getViewFieldPath(), $searchfield->getViewVars())
            @endforeach
        </div>
        <input name="_sl" type="hidden" value="{{$slfile}}">
        <button type="submit" class="btn btn-primary btn-sm btn-icon-split mb-2"  style="float: right;">
          <span class="icon text-white">
            <i class="fas fa-{{$filterIcon??'search'}}"></i>
          </span>
          <span class="text">Filtrar</span>
        </button>
      </form>               
    </div>
  </div>
</div>
            

<script type="text/javascript">
$(function() {
  var searchInits = @json($search_inits ?? []);
  for (var i in searchInits) {
    eval(searchInits[i]);
  }
});
</script>

<div class="row">
      <div class="col-lg-12">
        <!-- Filtros de Búsqueda -->
        <div class="card mb-4">
          <div class="card-header">
          Filtros de Búsqueda
          </div>
          <div class="card-body">
          <form method="get" action="{{url($url)}}" data-type="search">
            <div class="row">
                @foreach ($searchfields as $searchfield)
                @include($searchfield->getViewFieldPath(), $searchfield->getViewVars())
                @endforeach
            </div>
          <div>
          <input name="_sl" type="hidden" value="{{$slfile}}">
          <button type="submit" class="btn btn-primary btn-icon-split"  style="float: right;">
            <span class="icon text-white">
              <i class="fas fa-{{$filterIcon??'search'}}"></i>
            </span>
            <span class="text">Filtrar</span>
          </button>
        </div>
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

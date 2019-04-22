<div id="filtros" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="filtrosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="get" action="{{url($url)}}" data-type="search">
                <div class="modal-header">
                    <h5 class="modal-title">Filtros de Búsqueda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @foreach ($searchfields as $searchfield)
                        @include($searchfield->getViewFieldPath(), $searchfield->getViewVars())
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="_sl" type="hidden" value="{{$slfile}}">
                    <button class="btn btn-light btn-icon-split" data-dismiss="modal">
                      <span class="icon text-white">
                        <i class="fas fa-times"></i>
                      </span>
                      <span class="text">Cerrar</span>
                    </button>
                    <button type="submit" class="btn btn-primary btn-icon-split">
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

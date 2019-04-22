@foreach($cssincludes as $cssinclude)
<link href="{{asset($cssinclude)}}" media="all" rel="stylesheet" type="text/css" />
@endforeach
@hasSection('css_' . $name)
@yield('css_' . $name)
@endif

@hasSection($name)
@yield($name)
@endif

@foreach($jsincludes as $jsinclude)
<script type="text/javascript" src="{{asset($jsinclude)}}"></script>
@endforeach
@hasSection('js_' . $name)
@yield('js_' . $name)
@endif

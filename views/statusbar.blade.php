@if ((isset($_GET[Sledgehammer\DEBUG_VAR]) && $_GET[Sledgehammer\DEBUG_VAR]) || (isset($_GET[Sledgehammer\DEBUG_VAR]) === false && App::environment() == 'development') )
<div class="statusbar">
    <link href="{{ asset('sledgehammer/core/css/debug.css')}}" rel="stylesheet">
    <a href="#" onclick="this.parentNode.style.display = 'none'; return false" class="statusbar-close">&times;</a>
    {{ \Sledgehammer\statusbar() }}<span class="statusbar-divider">, </span><span id="statusbar-debugr" class="statusbar-tab"><a href="http://debugr.net/" target="_blank">debugR</a></span>
</div>
<script src="{{asset('sledgehammer/js/statusbar.js')}}"></script>
@endif
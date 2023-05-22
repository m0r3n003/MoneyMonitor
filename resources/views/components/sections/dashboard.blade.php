<footer>
    <span class="nav-items fa fa-fw fa-home fa-2x" id="btn_home"></span>
    <span class="selected_dashboard fa fa-fw fa-2x" id="selector"></span>
    @if (!isset($default))
    @can('cargarChat')
    <span class="nav-items fa fa-comment fa-2x"></span>
    @endcan
    @can('cargarUsuarios')
    <span class="nav-items fa fa-fw fa-users fa-2x"></span>
    @endcan
    <span class="nav-items fa fa-fw fa-cogs fa-2x"></span>
    @endif
</footer>

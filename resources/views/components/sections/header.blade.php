<header>
    <div class="seleccionEspacio">
        <h5>
            {{isset($espacio) ? ('Espacio: '.$espacio) : ('Seleccione un espacio de trabajo')}}
        </h5>
        <a href="/" class="btn_secondary--logout text-center">Cambiar de espacio</a>
    </div>
    <div id="mensajes">

    </div>
    <div class="d-flex header_derecha">
        <div id="saludo">
            Hola {{auth()->user()->Nombre}}
        </div>
        <div>
            <a href="/logout" class="btn_secondary--logout" id="logout">Cerrar sesión</a>
        </div>
    </div>

    <form action="{{route('index')}}" method="head" id="btn_volverACambiarEspacio" class="d-none">
    @csrf
    </form>
</header>

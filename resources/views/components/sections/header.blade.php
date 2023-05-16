<header>
    <div class="seleccionEspacio">
        <h5>
            {{isset($espacioActual) ? ('Espacio: '.$espacioActual) : ('Seleccione un espacio de trabajo')}}
        </h5>
        <button class="btn btn-success">Cambiar espacio</button>
    </div>
    <div id="mensajes">

    </div>
    <div>
        <div id="saludo">
            Hola {{auth()->user()->Nombre}}
        </div>
    </div>
</header>

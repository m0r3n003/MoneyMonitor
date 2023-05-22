<x-layouts.appLayout title="Selección de espacios">
    <x-sections.header select="disabled">

    </x-sections.header>
    <main class="d-flex justify-content-center">
        <div class="centered-div">
                @foreach ($listaGrupos as $grupo)
                    <h4 class="red_header" id="grupo_{{$grupo['GrupoID']}}">{{$grupo['grupoNombre']}}</h4>
                        <ul>
                            @if (isset($grupo['espacios']))
                            @foreach ($grupo['espacios'] as $espacio)
                            <li><a class="black_espacio espacio" href="{{route('changeEspacioSession', $espacio['id'])}}" id="espacio_{{$espacio['id']}}">{{$espacio['nombre']}}</a></li>
                            @endforeach
                            @endif
                            <li><a class="black_espacio nuevo_espacio" href="#" id="nuevo_espacio_{{$grupo['GrupoID']}}" data-toggle="modal" data-target="#nuevoEspacio">+ Añadir un nuevo espacio</a></li>
                        </ul>
                @endforeach
                    <h4 class="red_header"><a href="#" class="red_a" data-toggle="modal" data-target="#nuevoGrupo">+ Añadir un nuevo grupo</a></h4>





                    <!-- El modal -->
                    <div class="modal" id="nuevoGrupo">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Cabecera del modal -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Creación de grupo</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Contenido del modal -->
                                <div class="modal-body">
                                    <form action="{{route('crearGrupo')}}" method="post" id="formNuevoGrupo">
                                        @csrf
                                        <div class="form-group">
                                            <label for="groupName">Nombre del grupo</label>
                                            <input type="text" class="form-control" id="groupName" name="nombreGrupo" placeholder="">
                                        </div>
                                    </form>
                                </div>

                                <!-- Pie del modal -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" form="formNuevoGrupo" class="btn btn-success">Crear</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal" id="nuevoEspacio">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Cabecera del modal -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Creación de grupo</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Contenido del modal -->
                                <div class="modal-body">
                                    <form action="{{route('crearEspacio')}}" method="post" id="formNuevoEspacio">
                                        @csrf
                                        <input type="hidden" name="GrupoID" id="nuevoEspacio_GrupoID">
                                        <div class="form-group">
                                            <label for="espacioName">Nombre del espacio</label>
                                            <input type="text" class="form-control" id="espacioName" name="nombreEspacio" placeholder="">
                                        </div>
                                    </form>
                                </div>

                                <!-- Pie del modal -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" form="formNuevoEspacio" class="btn btn-success">Crear</button>
                                </div>
                            </div>
                        </div>
                    </div>

        </div>
    <script>
        $('.nuevo_espacio').each(function(index, element) {
            $(element).click(function (e) {
                $('#nuevoEspacio_GrupoID').val($(element).attr("id").split('_')[2]);
            })
        })
    </script>
    </main>
    <x-sections.dashboard default>

    </x-sections.dashboard>


</x-layouts.app>

<x-layouts.appLayout title="Espacios | {{$espacio->Nombre}}">
    <x-sections.header espacio="{{$espacio->Nombre}}" >

    </x-sections.header>
    <main>
        <div class="scrolleable-y" id="id_main">
            <div class="screen column container">
                <h3 class="color-green col-sm-12 d-flex d-md-inline-flex justify-content-center">Transacciones del 05/2023</h3>
                <div class="d-flex tablas">
                    <div class="col-md-6" id="tablaChart">
                        <div>
                            <div id="chart">
                                <canvas id="id_chart" ></canvas>
                                <script>
                                    // Datos de ejemplo
                                    let labels = [];
                                    @foreach ($chart as $key => $value)
                                        labels.push({{ $key }});
                                    @endforeach
                                    let data = [];
                                    @foreach ($chart as $key => $value)
                                        data.push({{ $value }});
                                    @endforeach
                                    const datosVentas = {
                                        labels: labels,
                                        datasets: [{
                                            label: 'Gastos mensuales',
                                            data: data,
                                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                            borderColor: 'rgba(54, 162, 235, 1)',
                                            borderWidth: 1
                                        }]
                                    };

                                    // Configuración del gráfico
                                    const config = {
                                        type: '{{$tipoformatotabla}}', // Tipo de gráfico: barras
                                        data: datosVentas,
                                        options: {
                                            reponsive: true,
                                            scales: {
                                                y: {
                                                    beginAtZero: true // Empieza en 0 en el eje y
                                                }
                                            }
                                        }
                                    };

                                    // Crear el gráfico
                                    var myChart = new Chart(document.getElementById('id_chart'), config);
                                </script>


                            </div>
                        </div>


                    </div>
                    <div class="col-md-6 border-left border-success" id="tablaTransacciones">
                        <div>
                            <table class="table table-bordered table-hover" id="tablaTransacciones">
                                <thead class="thead-light">
                                    <tr class="table-row">
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Descripcion</th>
                                        @can('cargarChat')
                                            <th scope="col"></th>

                                        @endcan
                                    </tr>
                                </thead>

                                @foreach ($tabla as $transaccion)
                                    <tr class="table-row">
                                        <th scope="row" id='fecha_{{$transaccion['TransaccionID']}}'>{{ $transaccion['DiaFormateado'] }}</th>
                                        <td id="cuantia_{{$transaccion['TransaccionID']}}">{{ $transaccion['Cuantia'] }}€</td>
                                        <td class="font-weight-bold" id="desc_{{$transaccion['TransaccionID']}}">{{ $transaccion['Descripcion'] }}</td>
                                        @can('cargarChat')
                                            <td class="font-weight-bold editTransact" id="editar_{{$transaccion['TransaccionID']}}" data-toggle="modal" data-target="#nuevaTransaccion">
                                                Editar
                                            </td>

                                        @endcan
                                    </tr>
                                @endforeach

                            </table>
                            <article class="text-right">
                                    <button data-toggle="modal" data-target="#nuevaTransaccion" class="btn btn-success" id="btn_addTra">+ Añadir transacción</button>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
            @can('cargarChat')
                <div class="screen" id="screen_chat">
                    <h3 class="color-green col-sm-12 d-flex d-md-inline-flex justify-content-center">Chat de: {{$espacio->Nombre}}</h3>
                    <div class="ventana_interior" id="chat">
                        <div id="pantalla_chat">
                            @csrf
                            <script>
                                function cargarChat () {
                                    $.ajax({
                                        type: "get",
                                        cache: false,
                                        url: "{{route('cargarChat', $espacio->EspacioID)}}",
                                        data: $('input[name="_token"]'),
                                        dataType: "json",
                                        success: function (response) {
                                            let generedHtml="";
                                            response.forEach(mensaje => {
                                                if (mensaje.From.Username == "{{auth()->user()->username}}") {
                                                    generedHtml += '<div class="mensaje_tu"><div class="mensaje"><div class="from_mensaje">'+mensaje.From.Nombre +' ('+mensaje.From.Username+')</div><div id="mensaje_'+mensaje.MensajeID+'">'+mensaje.Mensaje+'</div></div></div>'
                                                } else {
                                                    generedHtml += '<div class=""><div class="mensaje"><div class="from_mensaje">'+mensaje.From.Nombre +' ('+mensaje.From.Username+')</div><div id="mensaje_'+mensaje.MensajeID+'">'+mensaje.Mensaje+'</div></div></div>'
                                                }
                                            });
                                            if($('#pantalla_chat').html() != generedHtml) {
                                                console.log(response);
                                                $('#pantalla_chat').html(generedHtml);

                                                $('#pantalla_chat').scrollTop('10000000000000000000000');
                                            }
                                                // $('#pantalla_chat').html(generedHtml);
                                                // $('#pantalla_chat').scrollTop('10000000000000000000000');



                                        }
                                    });
                                }
                                setInterval(cargarChat, 500);
                            </script>
                        </div>
                        <form action="#" method="post">
                        <div class="input-group mb-3" id="formulario_container">
                                <input autocomplete="off" type="text" class="form-control" placeholder="Escribe tu mensaje" id="id_mensaje">
                                <div class="input-group-append">
                                    <button class="btn btn-success" id="boton_enviar"><span class="fa fa-paper-plane"></span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endcan
            @can('cargarUsuarios')
                <div class="screen" id="">
                    <h3 class="color-green col-sm-12 d-flex d-md-inline-flex justify-content-center">Gestión de usuarios del grupo</h3>
                    <div id="gestion_usuarios">
                        <div id="tabla_usuarios">
                            <table class="table table-bordered table-hover" id="tablaTransacciones">
                                <thead class="thead-light">
                                    <tr class="table-row">
                                        <th scope="col">Nombre usuario</th>
                                        <th scope="col">Nombre de la cuenta</th>
                                        <th scope="col">Permisos</th>
                                        <th scope="col"></th>

                                    </tr>
                                </thead>

                                @foreach ($usuarios as $usuario)
                                    <tr class="table-row">
                                        <th scope="row" id="nombre_usuario_{{$usuario['UsuarioID']}}">{{ $usuario['username'] }}</th>
                                        <td>{{ $usuario['Nombre'] }}</td>
                                        <td class="font-weight-bold">{{ $usuario['Permisos'] }}</td>
                                        @if ($usuario['Permisos'] != 'Administrador')
                                        <td class="font-weight-bold editarUsuario"  data-toggle="modal" data-target="#editarUsuario" id="usuario_{{$usuario['UsuarioID']}}">
                                            Editar
                                        </td>
                                        @endif


                                    </tr>
                                @endforeach

                            </table>
                        </div>
                        <div id="invitar_usuarios" class="text-right">
                            <button data-toggle="modal" data-target="#nuevoUsuario" class="btn btn-success" id="btn_addTra">+ Añadir transacción</button>

                        </div>
                    </div>
                </div>
            @endcan
            <div class="screen">
                <h3 class="color-green col-sm-12 d-flex d-md-inline-flex justify-content-center">Ajustes del usuario</h3>
                <div id="ajustes">
                    <div class="section_ajustes">
                        <h4 class="titulo_rojo text-align-left">Ajustes personales</h4>
                        <div class="contenido_ajustes">
                            <form action="{{route('cambiarFormatoTabla')}}" method="post" id="formulario_configuracion">
                                @csrf
                                <input type="hidden" name="ConfiguracionID" value="{{$ConfiguracionID}}">
                                <select name="formatoTabla" id="formatoTabla" class="form-control">
                                    <option value="0">Seleccione un formato de tabla</option>
                                    @foreach ($formatosTabla as $formatoTabla)
                                    <option value="{{$formatoTabla['FormatoTablaID']}}">{{$formatoTabla['FormatoTabla']}}</option>
                                    @endforeach
                                </select>
                            </form>
                            <div class="d-flex justify-content-end col-sm-12 mt-3">
                                <button class="btn btn-success" form="formulario_configuracion" type="submit">Guardar Configuracion</button>
                            </div>
                        </div>
                    </div>
                    <div class="section_ajustes border-top border-danger">
                        <h4 class="titulo_rojo">Cambiar espacio de trabajo</h4>
                            <div class="contenido_ajustes d-flex justify-content-end">
                                <a href="/" class="btn btn-danger text-center">Cambiar de espacio</a>
                            </div>
                    </div>

                    <div class="section_ajustes border-top border-danger">
                        <h4 class="titulo_rojo">Cerrar sesión</h4>
                            <div class="contenido_ajustes d-flex justify-content-end">
                                <a href="/" class="btn btn-danger text-center">Cerrar sesión</a>
                            </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal" id="nuevaTransaccion">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Cabecera del modal -->
                    <div class="modal-header">
                        <h4 class="modal-title">Transacción</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Contenido del modal -->
                    <div class="modal-body">
                        <form action="{{route('crearTransaccion')}}" method="post" id="formNuevaTransaccion">
                            @csrf
                            <input type="hidden" name="EspacioID" value="{{$espacio->EspacioID}}">
                            <input type="hidden" name="TransaccionID" value="" id="eliminarTransaccionID_add">
                            <div class="form-group">
                                <label for="Descripcion">Descripción</label>
                                <input type="text" class="form-control" id="Descripcion" name="descripcion" placeholder="ej. Factura Teléfono">
                            </div>
                            <div class="form-group">
                                <label for="Cantidad">Cantidad</label>
                                <input type="number" class="form-control" id="Cantidad" name="cantidad" placeholder="ej. 100.45">
                            </div>
                            <div class="form-group">
                                <label for="Fecha">Fecha</label>
                                <input type="date" class="form-control" id="Fecha" name="fecha" placeholder="ej. 100.45">
                            </div>
                        </form>
                        <form action="{{route('eliminarTransaccion')}}" method="POST" id="form_eliminar_tran">
                        @csrf
                            <input type="hidden" name="TransaccionID" id="eliminarTransaccionID_eliminar">
                        </form>
                    </div>

                    <!-- Pie del modal -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="btn_rem_tra">Eliminar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" form="formNuevaTransaccion" class="btn btn-success">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="nuevoUsuario">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Cabecera del modal -->
                    <div class="modal-header">
                        <h4 class="modal-title">Invitar usuario</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Contenido del modal -->
                    <div class="modal-body">
                        <form action="{{route('invitarUsuario')}}" method="post" id="formInvitar">
                            @csrf
                            <input type="hidden" name="EspacioID" value="{{$espacio->EspacioID}}">
                            <div class="form-group">
                                <label for="Fecha">Email del usuario</label>
                                <input type="email" class="form-control" id="emailUsuario" name="email">
                            </div>
                        </form>
                    </div>

                    <!-- Pie del modal -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" form="formInvitar" class="btn btn-success">Invitar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="editarUsuario">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Cabecera del modal -->
                    <div class="modal-header">
                        <h4 class="modal-title">Invitar usuario</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Contenido del modal -->
                    <div class="modal-body">
                        <form action="{{route('editarPermisos')}}" method="post" id="formEditarPermisos">
                            @csrf
                            <input type="hidden" name="UsuarioID" value="" id="usuarioEditarPermisos">
                            <input type="hidden" name="EspacioID" value="{{$espacio->EspacioID}}">
                            <div class="form-group">
                                <label for="Fecha">Permisos</label>
                                <select class="form-control" name="TipoPermisosID">
                                    <option value="0" disabled>Seleccione un tipo de permiso</option>
                                    @foreach ($permisos as $permiso)
                                        <option value="{{$permiso['TipoPermisosID']}}">{{$permiso['TipoPermisos']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>

                    <!-- Pie del modal -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" form="formEditarPermisos" class="btn btn-success">Editar</button>
                    </div>
                </div>
            </div>
        </div>





        <script>
            $('#boton_enviar').click(function (e) {
                e.preventDefault();
                $.ajax({
                                        type: "get",
                                        cache: false,
                                        url: "{{route('enviarMensaje', $espacio->EspacioID)}}",
                                        data: {
                                            '_token':$('input[name="_token"]').val(),
                                            'from':"{{auth()->user()->UsuarioID}}",
                                            'contenido': $('#id_mensaje').val()
                                        },
                                        dataType: "json",
                                        success: function (response) {
                                            $('#id_mensaje').val("");
                                        }
                                    });
            });
            $('.editTransact').each(function (index, element) {
                $(element).click(function (e) {
                    let id = $(element).attr('id').split('_')[1];
                    let partes = $('#fecha_'+id).text().split('/')
                    var dia = partes[0];
                    var mes = partes[1];
                    var anio = partes[2];

                    var fechaConvertida = anio + '-' + mes + '-' + dia; // Reorganizar las partes en el nuevo formato
                    $('#eliminarTransaccionID_add').val(id);
                    $('#eliminarTransaccionID_eliminar').val(id);
                    $('#Descripcion').val($('#desc_'+id).text());
                    $('#Cantidad').val($('#cuantia_'+id).text().substring(0, $('#cuantia_'+id).text().length-1));
                    $('#Fecha').val(fechaConvertida);
                })
            });
            $('#btn_addTra').click(function (element) {
                $('#Descripcion').val("");
                $('#Cantidad').val("");
                $('#Fecha').val("");
                $('#btn_rem_tra').addClass('d-none');
            });
            $('#btn_rem_tra').click(function (element) {
                var resultado = confirm("¿Estás seguro de que deseas eliminar esta transacción?");
                if (resultado) {
                    $('#form_eliminar_tran').submit();
                } else {

                }
            });
            $('.editarUsuario').each(function (index, element) {
                $(element).click(function(e) {
                    $('#usuarioEditarPermisos').val($(element).attr("id").split('_')[1]);
                })
            })


        </script>

    </main>
    <x-sections.dashboard>




    </x-sections.dashboard>

    </x-layouts.app>

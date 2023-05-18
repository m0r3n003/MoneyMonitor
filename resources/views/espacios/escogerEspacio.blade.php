<x-layouts.appLayout title="Selección de espacios">
    <x-sections.header select="disabled">

    </x-sections.header>
    <main class="d-flex justify-content-center">
        <div class="centered-div">
                @foreach ($listaGrupos as $grupo)
                    <h4 class="red_header" id="grupo_{{$grupo['GrupoID']}}">{{$grupo['grupoNombre']}}</h4>
                        <ul>
                            @foreach ($grupo['espacios'] as $espacio)
                            <li><a class="black_espacio espacio" href="{{route('escogerEspacio', $espacio['id'])}}" id="espacio_{{$espacio['id']}}">{{$espacio['nombre']}}</a></li>
                            @endforeach
                            <li><a class="black_espacio" href="#" id="nuevo_espacio_{{$grupo['GrupoID']}}">+ Añadir un nuevo espacio</a></li>

                        </ul>
                @endforeach
                    <h4 class="red_header"><a href="#" class="red_a">+ Añadir un nuevo grupo</a></h4>
                    <form action="#" method="get" class="d-none" id="form_getEspacios">
                        @csrf
                    </form>


        </div>
    </main>
    <x-sections.dashboard default>

    </x-sections.dashboard>

<script>
    $(document).ready(function () {
 $('.espacio').each(function(index, element) {
    $(element).click(function(e) {
        e.preventDefault();
        let id = $(this).attr('id').split('_')[1];
        $('#form_getEspacios').attr('action', "{{route('cargarEspacio')}}");


        $('#form_getEspacios').append('<input type="hidden" name="EspacioID" value="'+id+'">');
        $('#form_getEspacios').submit();
    });
 });
})


</script>


</x-layouts.app>

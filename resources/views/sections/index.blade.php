<x-app-layout titulo="Este es el titulo">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form action="{{route('validateLogin')}}" method="post">
                    <input type="text" name="username">
                    <input type="submit" value="Enviar">
                </form>

                @if (ISSET($username))
                    {{$username}}
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

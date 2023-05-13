<x-layouts.loginLayout>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-8">
                <div class="login-container">
                    <h3 class="text-left">Verifique su cuenta</h3>
                    <form method="POST" action="{{route('verificar')}}">
                        @csrf
                        <input type="hidden" name="userID" value="{{$user}}">
                        <div class="form-group">
                            <label for="login">Número de verificación</label>
                            <input type="text" class="form-control" name="verificacion" placeholder="Inserte el numero de verifiación">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger btn-block red-button">Verificar</button>
                        </div>
                        <div class="form-group">
                            <p>Revise su bandeja de entrada y busque el número de identifiación que le hemos enviado</p>
                            <p><a href="#">Reenviar código</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.loginLayout>

<x-layouts.loginLayout title="Inicio de Sesión">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-8">
                <div class="login-container">
                    <h3 class="text-left">Inicio de Sesión</h3>
                    <form method="POST" action="/validateLogin">
                        @csrf
                        <div class="form-group">
                            <label for="login">Nombre de usuario</label>
                            <input type="text" class="form-control" id="login" name="login" placeholder="">
                            @error('login')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="">
                            <span class="password fa fa-fw fa-eye password-icon show-password"></span>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" class="" id="recuerdame" name="remember">
                            <label for="recuerdame">Recuérdame</label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger btn-block red-button">Iniciar Sesión</button>
                        </div>
                        <div class="d-flex align-items-end align-links">
                            <a class="red-a" href="{{ route('register') }}">Darse de alta</a>
                            <a class="text-left red-a" href="{{ route('register') }}">Recordar contraseña</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </x-layouts.login>

<x-layouts.loginLayout title="Registro">
    <div class="container register">
        <div class="row">
            <div class="col-lg-6 col-md-8">
                <div class="login-container">
                    <h3 class="text-left">Registro</h3>
                    <form>
                        <div class="form-group">
                            <label for="username">Nombre de usuario</label>
                            <input type="email" class="form-control" id="username" placeholder="">
                        </div>
                        <div class="form-group agruparForm">
                            <div>
                                <label for="nombre">Nombre</label>
                                <input type="email" class="form-control" id="nombre" placeholder="">
                            </div>
                            <div>
                                <label for="apellidos">Apellidos</label>
                                <input type="email" class="form-control" id="apellidos" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tipousuario">Seleccione su cargo</label>
                            <select name="tipousuario" id="tipousuario" class="form-control">
                                <option value="">Seleccione un cargo</option>
                                @foreach ($cargos as $cargo)
                                    <option value="{{$cargo->TipoUsuarioID}}">{{$cargo->TipoUsuario}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email">Correo electrónico (se verficará posteriormente)</label>
                            <input type="email" class="form-control" id="email" placeholder="">
                        </div>
                        <div class="form-group agruparForm agruparForm50">
                            <div>
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" id="password" placeholder="">
                            </div>
                            <div>
                                <label for="password_repeat">Repita la contraseña</label>
                                <input type="password" class="form-control" id="password_repeat" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" class="" id="terminos">
                            <label for="terminos">He leído y acepto los <a href="{{ route('terminos') }}"
                                    target="_blank">términos y condiciones</a>.</label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger btn-block red-button">Registrarse</button>
                        </div>
                        <div class="d-flex align-items-end align-links">
                            <a class="red-a" href="{{ route('login') }}">Iniciar sesión</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </x-layouts.login>
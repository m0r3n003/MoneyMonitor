<x-layouts.loginLayout title="Registro">
    <div class="container register">
        <div class="row">
            <div class="col-lg-6 col-md-8">
                <div class="login-container">
                    <h3 class="text-left">Registro</h3>
                    <form method="post" action="{{ route('validateRegister') }}">
                        @csrf
                        <div class="form-group">
                            <label for="username">Nombre de usuario</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="">
                        </div>
                        <div class="form-group agruparForm">
                            <div>
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="Nombre" placeholder="">
                            </div>
                            <div>
                                <label for="apellidos">Apellidos</label>
                                <input type="text" class="form-control" id="apellidos" name="Apellidos"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tipousuario">Seleccione su cargo</label>
                            <select name="TipoUsuarioID" id="tipousuario" class="form-control">
                                <option value="">Seleccione un cargo</option>
                                @foreach ($cargos as $cargo)
                                    <option value="{{ $cargo->TipoUsuarioID }}">{{ $cargo->TipoUsuario }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email">Correo electrónico (se verficará posteriormente)</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="">
                        </div>
                        <div class="form-group agruparForm agruparForm50">
                            <div>
                                <label for="password">Contraseña</label>
                                <div class="div">
                                    <input type="password" class="form-control" id="password" name="password"
                                    placeholder=""/>
                                <span class="password fa fa-fw fa-eye password-icon show-password"></span>
                                </div>

                            </div>
                            <div>
                                <label for="password_repeat">Repita la contraseña</label>
                                <div class="div">
                                    <input type="password" class="form-control" id="password_repeat" placeholder=""/>
                                    <span class="password_repeat fa fa-fw fa-eye password-icon show-password"></span>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" class="" id="terminos">
                            <label for="terminos">He leído y acepto los <a href="{{ route('terminos') }}"
                                    target="_blank">términos y condiciones</a>.</label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger btn-block red-button" id="register-btn" disabled>Registrarse</button>
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

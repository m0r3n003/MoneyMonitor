<x-layouts.loginLayout title="Registro">
    <div class="container register">
        <div class="row">
          <div class="col-lg-6 col-md-8">
            <div class="login-container">
              <h3 class="text-left">Registro</h3>
              <form>
                <div class="form-group">
                  <label for="nombre">Nombre</label>
                  <input type="email" class="form-control" id="nombre" placeholder="">
                </div>
                <div class="form-group">
                  <label for="apellidos">Apellidos</label>
                  <input type="email" class="form-control" id="apellidos" placeholder="">
                </div>
                <div class="form-group">
                  <label for="username">Nombre de usuario</label>
                  <input type="email" class="form-control" id="username" placeholder="">
                </div>
                  <label for="email">Correo electrónico (se verficará posteriormente)</label>
                  <input type="email" class="form-control" id="email" placeholder="">
                </div>
                <div class="form-group">
                  <label for="password">Contraseña</label>
                  <input type="password" class="form-control" id="password" placeholder="">
                </div>
                <div class="form-group">
                  <label for="password_repeat">Repita la contraseña</label>
                  <input type="password" class="form-control" id="password_repeat" placeholder="">
                </div>
                <div class="form-group">
                    <input type="checkbox" class="form-control" id="terminos">
                  <label for="terminos">He leído y acepto los <a href="{{route('terminos')}}" target="_blank">términos y condiciones</a>.</label>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-danger btn-block red-button">Registrarse</button>
                </div>
                <div class="d-flex align-items-end align-links">
                    <a class="red-a" href="{{route('login')}}">Iniciar sesión</a>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
</x-layouts.login>

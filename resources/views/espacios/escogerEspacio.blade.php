<x-layouts.loginLayout title="Login">
    <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-8">
            <div class="login-container">
              <h3 class="text-center">Inicio de Sesión</h3>
              <form>
                <div class="form-group">
                  <label for="email">Correo Electrónico</label>
                  <input type="email" class="form-control" id="email" placeholder="Ingresa tu correo electrónico">
                </div>
                <div class="form-group">
                  <label for="password">Contraseña</label>
                  <input type="password" class="form-control" id="password" placeholder="Ingresa tu contraseña">
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                  <a href="{{route('register')}}"></a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
</x-layouts.login>

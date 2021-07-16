 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Crediges</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="Assets/css/app.min.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="Assets/css/style.css">
  <link rel="stylesheet" href="Assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="Assets/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href='Assets/img/favicon.ico' />
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">
              <div class="card-header">
                <h4>Inicio de sesion</h4>
              </div>
              <div class="card-body">
                <form method="POST" action="" class="needs-validation" novalidate="" id="formAcceso">
                  <div class="form-group">
                    <label for="name">Usuario</label>
                    <input id="nombre" type="text" class="form-control" name="nombre" tabindex="1" required autofocus placeholder="usuario">
                    <div class="invalid-feedback">
                      Por favor complete su usuario
                    </div>
                  </div>
                  <div class="form-group">
                      <label for="password" class="control-label">Contraseña</label>
                    <input id="clave" type="password" class="form-control" name="clave" tabindex="2" required placeholder="contraseña">
                    <div class="invalid-feedback">
                      Por favor ingrese su contraseña
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Iniciar sesion
                    </button>
                  </div>
                </form>

              </div>
            </div>
            <div class="mt-5 text-muted text-center">
              Sistema de gestión de préstamos
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

    <script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
    
  <script src="Views/modules/scripts/login.js"></script>

  <!-- General JS Scripts -->
  <script src="Assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="Assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="Assets/js/custom.js"></script>
    <script src="Assets/bundles/sweetalert/sweetalert.min.js"></script>
</body>


</html>
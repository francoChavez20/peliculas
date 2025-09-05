<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Panel Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #f8f9fa;
    }
    .login-card {
      max-width: 400px;
      width: 100%;
      padding: 2rem;
      border-radius: 0.5rem;
      box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
      background-color: #fff;
    }
    .login-icon {
      font-size: 4rem;
      color: #0d6efd;
      margin-bottom: 1rem;
      text-align: center;
    }
  </style>

   <!-- Sweet Alerts css -->
  <link href="<?php echo BASE_URL ?>src/views/pp/plugins/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
  <script>
    const base_url = '<?php echo BASE_URL; ?>';
    const base_url_server = '<?php echo BASE_URL_SERVER; ?>';
  </script>
</head>
</head>
<body>

  <div class="login-card">
    <div class="login-icon">
      <i class="fas fa-user-circle"></i>
    </div>
    <h3 class="text-center mb-4">Panel de Administración</h3>
    <form action="" id="frmIniciar">
      <div class="mb-3">
        <label for="username" class="form-label">Usuario</label>
        <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Ingrese su usuario" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña" required>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
      </div>
    </form>
    <p class="text-center mt-3 text-muted">&copy; 2025 Panel Admin</p>
  </div>
  
<script src="<?php echo BASE_URL; ?>src/views/js/funtions_login.js"></script>
<!-- Sweet Alerts Js-->
<script src="<?php echo BASE_URL ?>src/views/pp/plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel de Administración</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <style>
    html, body {
      height: 100%;
      margin: 0;
      font-family: Arial, sans-serif;
    }

    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* Wrapper principal */
    .wrapper {
      display: flex;
      flex: 1;
      min-height: 100vh; /* asegura que siempre llene la pantalla */
      width: 100%;
    }

    /* Sidebar */
    .sidebar {
      background: #fff;
      border-right: 1px solid #ddd;
      padding: 1rem;
      width: 250px; /* ancho fijo */
      min-height: 100vh; /* siempre llena la pantalla */
      overflow-y: auto; /* scroll interno si es necesario */
      flex-shrink: 0; /* no se encoge */
    }

    .sidebar .nav-link {
      color: #333;
      border-radius: 8px;
      margin-bottom: .3rem;
    }

    .sidebar .nav-link.active {
      background: #3b82f6;
      color: #fff;
    }

    .sidebar .nav-link:hover {
      background: #e6f0ff;
    }

    .section-title {
      font-size: 0.8rem;
      text-transform: uppercase;
      font-weight: 600;
      margin-top: 1.5rem;
      margin-bottom: .5rem;
      color: #6c757d;
    }

    /* Topbar */
    .topbar {
      background: #fff;
      border-bottom: 1px solid #ddd;
      padding: 0.5rem 1rem;
      position: sticky;
      top: 0;
      z-index: 1030;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .topbar .form-control {
      border-radius: 12px;
    }

    .profile-img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
    }

    .username {
      font-weight: 600;
      margin-bottom: -4px;
    }

    .user-role {
      font-size: 0.8rem;
      color: #6c757d;
    }

    /* Contenido principal */
    main {
      flex: 1; /* ocupa todo el espacio restante */
      overflow-y: auto; /* scroll si contenido es largo */
      padding: 1rem;
      min-height: 100vh; /* asegura altura mínima igual a la pantalla */
    }

    /* Ajuste responsive */
    @media (max-width: 768px) {
      .sidebar {
        position: fixed;
        top: 0;
        left: -250px;
        height: 100%;
        z-index: 1040;
        transition: left 0.3s;
      }

      .sidebar.show {
        left: 0;
      }

      main {
        margin-left: 0;
      }
    }
  </style>

  <script>
    const base_url = "<?php echo BASE_URL; ?>";

    // Toggle sidebar en móviles
    document.addEventListener('DOMContentLoaded', function() {
      const toggleBtn = document.querySelector('.btn-outline-primary');
      const sidebar = document.querySelector('.sidebar');

      toggleBtn.addEventListener('click', function() {
        sidebar.classList.toggle('show');
      });
    });

    async function cerrar_sesion() {
      try {
        let respuesta = await fetch(base_url+'src/controller/login.php?tipo=cerrar_sesion',{
          method: 'POST', 
          mode: 'cors',
          cache:'no-cache',
        });
        let json = await respuesta.json();
        if (json.status) {
          location.replace(base_url+'login');
        }
      } catch(e) {
        console.error(e);
      }
    }
  </script>
</head>
<body>

  <div class="wrapper">
    <!-- Sidebar -->
    <nav class="sidebar">
      <div class="logo d-flex align-items-center mb-3">
        <i class="bi bi-yin-yang fs-4 text-primary"></i>
        <span class="fw-bold ms-2">YIN YANG</span>
      </div>

      <div class="section-title">Inicio</div>
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASE_URL;?>inicio"><i class="bi bi-grid me-2"></i> Dashboard</a>
        </li>
      </ul>

      <div class="section-title">Menus</div>
      <ul class="nav flex-column">
        <li><a class="nav-link" href="<?php echo BASE_URL;?>peliculas"><i class="bi bi-film me-2"></i> Peliculas</a></li>
        <li><a class="nav-link" href="<?php echo BASE_URL;?>generos"><i class="bi bi-card-list me-2"></i> Generos</a></li>
      </ul>

      <div class="section-title">Cerrar Sesión</div>
      <div class="mt-3">
        <button type="button" onclick="cerrar_sesion();" class="btn btn-danger w-100">
          <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
        </button>
      </div>
    </nav>

    <!-- Main content -->
    <main>
      <!-- Topbar -->
      <div class="topbar">
        <div class="d-flex align-items-center gap-3">
          <button class="btn btn-outline-primary d-md-none" type="button">
            <i class="bi bi-list fs-4"></i>
          </button>
          <i class="bi bi-diagram-2 fs-4 text-primary"></i>
          <span class="fw-bold">Sistema de Películas</span>
        </div>

        <div class="d-flex align-items-center gap-3">
          <img src="https://flagcdn.com/w40/pe.png" class="rounded-circle" width="30" height="30" alt="Bandera">

          <?php
          if (session_status() === PHP_SESSION_NONE) {
              session_start();
          }
          $nombre = $_SESSION['sesion_ventas_usuario'] ?? 'Nombre';
          $apellido = $_SESSION['sesion_ventas_apellido'] ?? 'Apellido';
          $rol = $_SESSION['sesion_ventas_rol'] ?? 'Invitado';
          $nombreCompleto = $nombre . ' ' . $apellido;
          ?>

          <div class="d-flex align-items-center gap-2">
            <img src="https://i.pravatar.cc/40?img=12" alt="User" class="profile-img">
            <div class="d-none d-sm-block">
              <div class="username"><?= htmlspecialchars($nombreCompleto) ?></div>
              <div class="user-role"><?= htmlspecialchars($rol) ?></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Contenido principal -->
      <div class="content py-4">
        

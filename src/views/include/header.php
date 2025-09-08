

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
    }
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      font-family: Arial, sans-serif;
    }
    .wrapper {
      flex: 1; /* ocupa todo el espacio entre header y footer */
      display: flex;
    }
    /* Sidebar */
    .sidebar {
      min-height: 100%;
      background: #fff;
      border-right: 1px solid #ddd;
      padding: 1rem;
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
  </style>
</head>
<body>
  <div class="wrapper container-fluid">
    <div class="row flex-grow-1">
      <!-- Sidebar -->
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
        <div class="logo d-flex align-items-center mb-3">
           <i class="bi bi-yin-yang fs-4 text-primary"></i>
            <span class="fw-bold">  YIN YANG</span>
        </div>
        <div class="section-title">Inicio</div>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="#"><i class="bi bi-grid me-2"></i> Dashboard</a>
          </li>
          
        </ul>

        <div class="section-title">Menus</div>
        <ul class="nav flex-column">
          <li><a class="nav-link" href="<?php echo BASE_URL;?>peliculas"><i class="bi bi-film me-2"></i> Peliculas</a></li>
          <li><a class="nav-link" href="<?php echo BASE_URL;?>generos"><i class="bi bi-card-list me-2"></i> Generos</a></li>
          <!--<li><a class="nav-link" href="#"><i class="bi bi-people me-2"></i> Users</a></li>
          <li><a class="nav-link" href="#"><i class="bi bi-tools me-2"></i> Utilities</a></li>
          <li><a class="nav-link" href="#"><i class="bi bi-lock-fill me-2"></i> Admin</a></li>-->
        </ul>

        <div class="section-title">Cerrar Sesión</div>
        <div class="d-flex  mt-3">
  <form action="src/controller/logout.php" method="POST">
    <button type="submit" class="btn btn-danger w-100">
      <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
    </button>
  </form>
</div>

      </nav>

      <!-- Main content -->
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 d-flex flex-column">
        <!-- Topbar -->
        <div class="d-flex justify-content-between align-items-center topbar">
          <!-- Hamburguesa + Logo + Buscar -->
          <div class="d-flex align-items-center gap-3">
            <button class="btn btn-outline-primary d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
              <i class="bi bi-list fs-4"></i>
            </button>
            <i class="bi bi-diagram-2 fs-4 text-primary"></i>
            <span class="fw-bold">Sistema de peliculas</span>
          </div>
          
          <!-- Acciones -->
          <div class="d-flex align-items-center gap-3">
          
            <img src="https://flagcdn.com/w40/pe.png" class="rounded-circle" width="30" height="30" alt="Bandera">
           

<div class="d-flex align-items-center gap-2">
  <img src="https://i.pravatar.cc/40?img=12" alt="User" class="profile-img">
  <div class="d-none d-sm-block">
    <div class="username"><?= htmlspecialchars($_SESSION['sesion_ventas_usuario'] ?? 'Usuario') ?></div>
    <div class="user-role"><?= htmlspecialchars($_SESSION['sesion_ventas_rol'] ?? 'rol') ?></div>
  </div>
</div>

          </div>
        </div>

        <!-- Contenido principal -->
        <div class="content flex-grow-1 py-4">
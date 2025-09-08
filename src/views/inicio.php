<?php
// Conexión a la base de datos
require_once "./src/config/config.php";

$conn = new mysqli(BD_HOST, BD_USER, BD_PASSWORD, BD_NAME);
$conn->set_charset("utf8");

// Contar géneros
$result = $conn->query("SELECT COUNT(*) as total FROM generos");
$generos = $result->fetch_assoc()['total'];

// Contar películas
$result = $conn->query("SELECT COUNT(*) as total FROM peliculas");
$peliculas = $result->fetch_assoc()['total'];

// Contar usuarios
$result = $conn->query("SELECT COUNT(*) as total FROM usuario");
$usuarios = $result->fetch_assoc()['total'];

$conn->close();
?>

<div class="d-flex gap-3" style="width:100%; padding:1rem;">
  <!-- Tarjeta Géneros -->
  <div class="flex-fill" style="border-radius:12px; box-shadow:0 2px 6px rgba(0,0,0,0.1); padding:1.5rem; display:flex; justify-content:space-between; align-items:center; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
    <div>
      <h5>Géneros</h5>
      <h3><?= $generos ?></h3>
    </div>
    <div style="font-size:2.5rem; color:#3b82f6;">
      <i class="bi bi-card-list"></i>
    </div>
  </div>

  <!-- Tarjeta Películas -->
  <div class="flex-fill" style="border-radius:12px; box-shadow:0 2px 6px rgba(0,0,0,0.1); padding:1.5rem; display:flex; justify-content:space-between; align-items:center; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
    <div>
      <h5>Películas</h5>
      <h3><?= $peliculas ?></h3>
    </div>
    <div style="font-size:2.5rem; color:#3b82f6;">
      <i class="bi bi-film"></i>
    </div>
  </div>

  <!-- Tarjeta Usuarios -->
  <div class="flex-fill" style="border-radius:12px; box-shadow:0 2px 6px rgba(0,0,0,0.1); padding:1.5rem; display:flex; justify-content:space-between; align-items:center; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
    <div>
      <h5>Usuarios</h5>
      <h3><?= $usuarios ?></h3>
    </div>
    <div style="font-size:2.5rem; color:#3b82f6;">
      <i class="bi bi-people"></i>
    </div>
  </div>
</div>

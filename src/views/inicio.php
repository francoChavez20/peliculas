<?php
// Conexión a la base de datos
require_once "./src/config/config.php";

$conn = new mysqli(BD_HOST, BD_USER, BD_PASSWORD, BD_NAME);
$conn->set_charset("utf8");

// Contar películas
$result = $conn->query("SELECT COUNT(*) AS total FROM peliculas");
$peliculas = ($result) ? $result->fetch_assoc()['total'] : 0;

// Contar usuarios
$result = $conn->query("SELECT COUNT(*) AS total FROM usuario");
$usuarios = ($result) ? $result->fetch_assoc()['total'] : 0;

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
      

        .dashboard-container {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .card-dashboard {
            flex: 1 1 250px;
            background-color: #ffffff;
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card-dashboard:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }

        .card-dashboard h5 {
            margin: 0;
            font-size: 1.1rem;
            color: #555;
        }

        .card-dashboard h3 {
            margin: 0;
            font-size: 2rem;
            color: #333;
        }

        .card-icon {
            font-size: 3rem;
            color: #3b82f6;
        }
    </style>
</head>
<body>

    <h1 class="mb-4">Dashboard</h1>

    <div class="dashboard-container">

        <!-- Tarjeta Películas -->
        <div class="card-dashboard">
            <div>
                <h5>Películas Registradas</h5>
                <h3><?= $peliculas ?></h3>
            </div>
            <div class="card-icon">
                <i class="bi bi-film"></i>
            </div>
        </div>

        <!-- Tarjeta Usuarios -->
        <div class="card-dashboard">
            <div>
                <h5>Usuarios Registrados</h5>
                <h3><?= $usuarios ?></h3>
            </div>
            <div class="card-icon">
                <i class="bi bi-people"></i>
            </div>
        </div>

    </div>

</body>
</html>

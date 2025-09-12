<head>
    <style>
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #6dd5fa, #2980b9);
        }

        .form {
            background-color: #ffffff;
            margin: 20px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
            width: 500px;
            font-family: Arial, sans-serif;
        }

        .form div {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 15px;
            background-color: #f7f9fc;
            transition: all 0.3s ease;
        }

        input:focus,
        textarea:focus {
            border-color: #2980b9;
            background-color: #eaf4fc;
        }

        .button {
            width: 100%;
            padding: 15px;
            background-color: #2980b9;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 17px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #2575a7;
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 25px;
        }
    </style>
</head>

<body>
   <div class="form-container">
    <form class="form" id="frmEditarUsuario">
        <h2>Editar Usuario</h2>
        <input type="hidden" id="id_usuario" name="id_usuario">

        <div>
            <label for="nombres">Nombre</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>

        <div>
            <label for="apellidos">Apellido</label>
            <input type="text" id="apellido" name="apellido" required>
        </div>

        <div>
            <label for="rol">Rol</label>
            <select id="rol" name="rol" required>
                <option value="">Seleccione un rol</option>
                <option value="admin">Administrador</option>
                <option value="usuario">Usuario</option>
            </select>
        </div>

        <button type="button" class="button" onclick="actualizar_usuario();">Actualizar Usuario</button>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </form>
</div>


    <!-- JS -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="<?php echo BASE_URL ?>src/views/js/functions_pelicula.js"></script>


    <script>
        // Capturamos el ID desde la URL
        const id_p = <?php $pagina = explode("/", $_GET['views']); echo $pagina[1]; ?>;
        editar_pelicula(id_p);
    </script>
</body>

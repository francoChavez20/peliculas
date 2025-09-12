<style>
    .form-container {
        margin: 0px;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 90vh;
        background-color: #f0f2f5;
    }

    .form {
        background-color: #ffffff;
        margin: 20px;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 500px;
        font-family: Arial, sans-serif;
    }

    .form div {
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #333;
    }

    input[type="text"],
    input[type="password"],
    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        font-size: 14px;
        background-color: #f9f9f9;
    }

    .button {
        width: 100%;
        padding: 12px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        transition: background-color 0.3s ease;
        margin-bottom: 10px; /* separación con el botón eliminar */
    }

    .button:hover {
        background-color: #45a049;
    }

    .button-delete {
        width: 100%;
        padding: 12px;
        background-color: #e74c3c;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .button-delete:hover {
        background-color: #c0392b;
    }

    input:focus,
    select:focus {
        border-color: #4CAF50;
        outline: none;
        background-color: #f1f9f1;
    }

    h2 {
        text-align: center;
        color: #333;
        font-size: 24px;
        margin-bottom: 20px;
    }
</style>

<!-- Contenedor centrado -->
<div class="form-container">
    <form class="form" action="" id="frmRegistrarUsuario" autocomplete="off">
        <h2>Registrar Usuario</h2>

        <div>
            <label for="nombre">Nombre</label>
            <input type="text" id="nombres" name="nombre" placeholder="Nombre del usuario" required>
        </div>

        <div>
            <label for="apellido">Apellido</label>
            <input type="text" id="apellidos" name="apellido" placeholder="Apellido del usuario" required>
        </div>

        <div>
            <label for="password">Contraseña</label>
            <input type="password" id="passwords" name="password" placeholder="Contraseña segura" required>
        </div>

        <div>
            <label for="rol">Rol</label>
            <select id="rol_reg" name="rol" required>
                <option value="">Seleccione un rol</option>
                <option value="administrador">Administrador</option>
                <option value="gerente">Gerente</option>
                <option value="usuario">Usuario</option>
            </select>
        </div>

        <!-- Botón Guardar -->
        <button type="button" class="button" onclick="registrar_usuario();">Guardar Usuario</button>


<a href="<?php echo BASE_URL;?>usuario"> <button type="button" class="button-delete">Eliminar Usuario</button>
</a>
        <!-- Botón Eliminar -->
       
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </form>
</div>

<!-- JS -->
<script src="<?php echo BASE_URL ?>src/views/js/functions_usuario.js"></script>

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
    input[type="date"],
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
        margin-bottom: 10px;
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
<!-- Contenedor centrado -->
<div class="form-container">
    <form class="form" action="" id="frmRegistrarToken" autocomplete="off">
        <h2>Registrar Token</h2>

          <div class="mb-3">
        <label for="id_cliente" class="form-label">Cliente</label>
        <select id="id_cliente" name="id_cliente" class="form-control">
            <option value=""><-Seleccione un cliente-></option>
        </select>
    </div>

        <div>
            <label for="token">Token</label>
            <!-- Ahora solo lectura, no se ingresa manual -->
            <input type="text" id="token" name="token" placeholder="Token generado automáticamente" readonly>
        </div>

        <div>
            <label for="estado">Estado</label>
            <select id="estado" name="estado" required>
                <option value="">Seleccione estado</option>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>
        </div>

        <!-- Botón Guardar -->
        <button type="button" class="button" onclick="registrar_token();">Guardar Token</button>

        <!-- Botón Cancelar -->
        <a href="<?php echo BASE_URL;?>token">
            <button type="button" class="button-delete">Cancelar</button>
        </a>

        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </form>
</div>

<!-- JS -->
<script src="<?php echo BASE_URL ?>src/views/js/functions_token.js"></script>


<!-- JS -->
<script src="<?php echo BASE_URL ?>src/views/js/functions_token.js"></script>

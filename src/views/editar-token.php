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
        background-color: #2196F3;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .button:hover {
        background-color: #1976D2;
    }

    input:focus,
    select:focus {
        border-color: #2196F3;
        outline: none;
        background-color: #f1f9ff;
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
    <form class="form" action="" id="frmEditarToken">
        <h2>Editar Token</h2>

        <!-- ID oculto -->
        <input type="hidden" id="id_token" name="id_token">

        <div>
            <label for="id_cliente_api">Cliente</label>
            <select id="id_cliente_api" name="id_cliente_api" required>
                <option value="">Seleccione cliente</option>
                <!-- Aquí se cargarán clientes dinámicamente desde JS -->
            </select>
        </div>

        <div>
            <label for="token">Token</label>
            <input type="text" id="token" name="token" value="" required>
        </div>

        <div>
            <label for="estado">Estado</label>
            <select id="estado" name="estado" required>
                <option value="">Seleccione estado</option>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>
        </div>

        <button type="button" class="button" onclick="actualizar_token();">Actualizar Token</button>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </form>
</div>

<!-- JS -->
<script src="<?php echo BASE_URL ?>src/views/js/functions_token.js"></script>
<script>
    // Capturamos el ID desde la URL
    const id_p = <?php $pagina = explode("/", $_GET['views']); echo $pagina[1]; ?>;
    editar_token(id_p);
</script>

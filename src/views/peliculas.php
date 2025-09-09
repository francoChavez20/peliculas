
    <!-- Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12 d-flex justify-content-between align-items-center">
                    <h1 class="m-0">Listado de Películas</h1>
                    <a href="<?php echo BASE_URL;?>nueva-peli">
                        <button type="button" class="btn btn-success">
                            <i class="fa fa-plus"></i> Agregar Nueva Película
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Card -->
    <div class="card card-primary m-2 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Películas</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="tablaPeliculas" class="table table-striped table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Nro</th>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Año Estreno</th>
                            <th>Duración</th>
                            <th>Calificación</th>
                            <th>Idioma</th>
                            <th>Género</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbl_peliculas" style="font-family: 'Times New Roman', Times, serif;">
                        <!-- Aquí se llenarán los datos dinámicamente -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="<?php echo BASE_URL ?>src/views/js/functions_pelicula.js"></script>
</div>

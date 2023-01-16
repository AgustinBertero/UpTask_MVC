
<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="contenedor-sm">
    <div class="contenedor-nueva-tarea">
        <button
        type="button"
        class="agregar-tarea"
        id="agregar-tarea">
        &#43; New task</button>
    </div>

    <div id="filtros" class="filtros">
        <div class="filtros-input">
            <h2>Filters:</h2>
            <div class="campo">
                <label for="todas">All</label>
                <input 
                type="radio"
                id="todas"
                name="filter"
                value=""
                checked    
                >
            </div>

            <div class="campo">
                <label for="completadas">Completed</label>
                <input 
                type="radio"
                id="completadas"
                name="filter"
                value="1" 
                >
            </div>

            <div class="campo">
                <label for="pendientes">Pending</label>
                <input 
                type="radio"
                id="pendientes"
                name="filter"
                value="0" 
                >
            </div>
        </div>
    </div>

    <ul id="listado-tareas"  class="listado-tareas">

    </ul>
</div>


<?php include_once __DIR__ . '/footer-dashboard.php'; ?>


<?php 

$script .= '
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/../build/js/tareas.js"></script>

';



?>
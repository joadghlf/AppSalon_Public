<h1 class="nombre-pagina">Reservas</h1>

<?php 
    echo "<p class='descripcion-pagina'>Hola ".$usuario->nombre.", elige el día y el horario de tu cita</p>";
?>

<div class="app">
    <nav class="tabs">
        <button type="button" class="btn btn-secondary tab" data-paso="1">Servicios</button>
        <button type="button" class="btn btn-secondary tab" data-paso="2">información cita</button>
        <button type="button" class="btn btn-secondary tab" data-paso="3">Resumen</button>
    </nav>
    <div class="seccion" id="paso-1">
        <h2>Servicios</h2>
        <p>Elige tus servicios a continuación</p>
        <div class="listado-servicios" id="servicios"></div>
    </div>
    <div class="seccion" id="paso-2">
        <h2>Tus datos y Cita</h2>
        <p>Coloca tus datos y fecha de tu cita</p>


        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" placeholder="Tu Nombre" value="<?php echo $usuario->nombre; ?>">
                <input type="hidden" id="id" value="<?php echo $usuario->id;?>">
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" min="<?php echo date('Y-m-d', strtotime('+1 day'));?>">
            </div>
            <div class="campo">
                <label for="hora">hora</label>
                <input type="time" id="hora">
            </div>
        </form>

    </div>
    <div class="seccion" id="paso-3">
        <h2>Resumen</h2>
        <p>Verifica que la información sea correcta</p>
        <div class="mostrar-resumen">
            
        </div>
    </div>

    <div class="paginacion">
        <button id="anterior" class="btn btn-primary">&laquo; Anterior</button>
        <button id="siguiente" class="btn btn-primary">Siguiente &raquo;</button>
    </div>
</div>

<?php
if(!isset($script)){
    $script = "";
}
    $script .= "
        <script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>
    "
?>
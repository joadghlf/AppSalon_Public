<h1 class="nombre-pagina">Panel administrador</h1>

<?php
    $pagina = "Servicios";
    $type = "servicio";
    $btnServicios = 'btn-select';
    include_once 'templates/nav.php';
?>

<section class="admin">
    <form action="">
        <div class="campo">
            <label for="servicio" class="text-center">Servicio: </label>
            <input type="search" id="buscador">
        </div>
    </form>
    <table class="admin-servicios">        
        <?php
        if(isset($servicios)){
            ?>
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
                <?php

            foreach ($servicios as $key => $servicio) { ?>
                <tr class="servicio-adm" data-id="<?php echo $servicio->id ?>">
                        <td><p class="busqueda-class"><?php echo $servicio->nombre ?></p></td>
                        <td><p><?php echo $servicio->precio ?></span></p></td>
                        <td class="acciones">
                            <a class="btn btn-modificar" href="\admin\servicios\modificar?id=<?php echo $servicio->id?>&type=<?php echo $type ?>">Modificar</a>
                            <a class="btn btn-eliminar" href="">Eliminar</a>
                        </td>
                    </div>
                </li>
            </tr>
        <?php }
        } ?>
        </tbody>
    </table>
</section>
<?php 
if(!isset($script)){
    $script = "";
}
$script .= "<script src='/build/js/buscadores.js'></script>";
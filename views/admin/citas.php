<h1 class="nombre-pagina">Panel administrador</h1>

<?php
    $pagina = "Citas";
    $type = "cita";
    $btnCitas = 'btn-select';
    include_once 'templates/nav.php';
?>

<section class="admin">
    <form action="">
        <div class="campo fecha">
            <label for="fecha">Fecha: </label>
            <input type="date" id="buscadorFecha" value="<?php echo $fecha?>">
        </div>
    </form>
    <ul class="citas">
        <?php 
        $idCita = 0;
        $total = 0;
        if(isset($citas)){
            foreach ($citas as $key => $cita) { ?>
            <?php
            if ($idCita !== $cita->id) { ?>
                <li class="cita">

                    <div class="datos-cliente">
                        <p>ID: <span><?php echo $cita->id ?></span></p>
                        <p>Cita: <span><?php echo $cita->cita ?></span></p>
                        <p>Cliente: <span><?php echo $cita->cliente ?></span></p>
                        <p>Email: <span><?php echo $cita->email ?></span></p>
                        <p>Telefono: <span><?php echo $cita->telefono ?></span></p>
                    </div>
                    <h3>Servicios</h3>
                    <div class="servicios">
                    <?php $idCita = $cita->id;
                } ?>
                    <p><?php echo $cita->servicio . " <span>" . $cita->precio . "</span>"
                        ?></p>

                <?php
                $total += $cita->precio;
                if ($key < (sizeof($citas) - 1)) {
                    $citaProxima = $citas[$key + 1]->id;
                    if ($idCita !== $citaProxima) {
                        echo "<p>Total:" . " <span>" . $total . "</span></p>";
                        $total = 0;
                        ?>
                        <form action="/api/eliminar" method="post">
                        <input type="hidden" value="<?php echo $cita->id?>" name="idcita">
                        <input type="submit" value="Eliminar" class="btn btn-eliminar">
                        </form>
                        <?php
                    }
                } else {
                    echo "<p>Total:" . " <span>" . $total . "</span></p>";
                        ?>
                    <form action="/api/eliminar" method="post">
                    <input type="hidden" value="<?php echo $cita->id?>" name="idcita">
                    <a class="btn btn-modificar" href="\admin\citas\modificar?id=<?php echo $cita->id?>&type=<?php echo $type ?>">Modificar</a>
                    <input type="submit" value="Eliminar" class="btn btn-eliminar">
                    </form>
                    <?php
                }
                
            }
        }  ?>
                    </div>
                </li>


    </ul>
</section>
</table>

<?php 
if(!isset($script)){
    $script = "";
}
$script .= "<script src='../build/js/buscadores.js'></script>";
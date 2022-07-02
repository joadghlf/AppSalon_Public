<h1 class="nombre-pagina">Panel administrador</h1>

<?php
    $pagina = "Usuarios";
    $type = "usuario";
    $btnUsuarios = 'btn-select';
    include_once 'templates/nav.php';
?>

<section class="admin">
    <form action="">
        <div class="campo">
            <label for="usuario" class="text-center">Usuario: </label>
            <input type="search" id="buscador">
        </div>
    </form>
    <table class="admin-usuarios">        
        <?php
        if(isset($usuarios)){
            ?>
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
                <?php

            foreach ($usuarios as $key => $usuario) { ?>
                <tr class="usuario-adm" data-id="<?php echo $usuario->id ?>">
                        <td><p class="busqueda-class"><?php echo $usuario->nombre.' '.$usuario->apellido?></p></td>
                        <td><p><?php echo $usuario->email ?></span></p></td>
                        <td class="acciones">
                            <a class="btn btn-modificar" href="\admin\usuarios\modificar?id=<?php echo $usuario->id?>&type=<?php echo $type ?>">Modificar</a>
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
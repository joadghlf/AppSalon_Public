<h1 class="nombre-pagina">Panel administrador</h1>

<?php
    $pagina = "Modificando ".$type;
    include_once 'nav.php';

use Model\Servicio;
use Model\Cita;
use Model\Usuario;
    
    imprimirErrores($errores);
    echo $element->formVal('campo',$camposNo);    
?>
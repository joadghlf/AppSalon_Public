<?php
    echo "<h3 class='descripcion-pagina'>${pagina}</h3>";
    $classCitas = $btnCitas  ?? null;
    $classServicios = $btnServicios  ?? null;
    $classUsuarios = $btnUsuarios ?? null;
?>
<nav class="nav-admin">
    <a href="/admin/citas" class="btn-nav btn <?php echo $classCitas ?>">Citas</a>
    <a href="/admin/servicios" class="btn-nav btn <?php echo $classServicios ?>">Servicios</a>
    <a href="/admin/usuarios" class="btn-nav btn <?php echo $classUsuarios ?>">Usuarios</a>
    <!-- <a href="" class="btn-nav btn"></a> -->
</nav>

<?php if(isset($crear)){ ?>
    <div class="option-adm">
    <a class="option option-add" href="/admin/<?php echo strtolower($type)."s" ?>/crear?type=<?php echo $type?>">
    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM256 368C269.3 368 280 357.3 280 344V280H344C357.3 280 368 269.3 368 256C368 242.7 357.3 232 344 232H280V168C280 154.7 269.3 144 256 144C242.7 144 232 154.7 232 168V232H168C154.7 232 144 242.7 144 256C144 269.3 154.7 280 168 280H232V344C232 357.3 242.7 368 256 368z"/></svg>
    </a>
</div>
<?php }else{ ?>
    <div class="option-adm">
    <a class="option option-back" href="/admin/<?php echo strtolower($type)."s" ?>">
    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M31.1 64.03c-17.67 0-31.1 14.33-31.1 32v319.9c0 17.67 14.33 32 32 32C49.67 447.1 64 433.6 64 415.1V96.03C64 78.36 49.67 64.03 31.1 64.03zM267.5 71.41l-192 159.1C67.82 237.8 64 246.9 64 256c0 9.094 3.82 18.18 11.44 24.62l192 159.1c20.63 17.12 52.51 2.75 52.51-24.62v-319.9C319.1 68.66 288.1 54.28 267.5 71.41z"/></svg>
    </a>
<?php } ?>

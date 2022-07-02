<h1 class="nombre-pagina">Crear cuenta</h1>
<p class="descripcion-pagina">Ingrese sus datos para dar de alta la cuenta</p>

<?php
    imprimirErrores($errores);
?>

<form action="#" class="formulario" method="POST">
    <fieldset>
    <div class="campo">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" placeholder="Su nombre" value="<?php echo sanitizar($usuario->nombre)?>" required>
    </div>
    <div class="campo">
        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" id="apellido" placeholder="Su apellido" value="<?php echo sanitizar($usuario->apellido)?>" required>
    </div>
    <div class="campo">
        <label for="email">email:</label>
        <input type="email" name="email" id="email" placeholder="Su email" value="<?php echo sanitizar($usuario->email)?>" required>
    </div>
    <div class="campo">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="Su password" required>
    </div>
    <div class="campo">
        <label for="password2">Password:</label>
        <input type="password" name="password2" id="password2" placeholder="repita el password" required>
    </div>
    <div class="campo">
        <label for="telefono">Telefono:</label>
        <input type="text" name="telefono" id="telefono" placeholder="Su telefono" value="<?php echo sanitizar($usuario->telefono)?>" required>
    </div>
    <input type="submit" class="btn btn-primary" value="Crear">

    </fieldset>
</form>

<div class="links">
    <a href="<?php imprimirVolver()?>" class="btn">Volver</a>
</div>
<h1 class="nombre-pagina">Loguin</h1>
<p class="descripcion-pagina">Coloque su mail para recuperar el password</p>

<?php
    imprimirErrores($errores);
?>

<form class="formulario" action="#" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="tumail@mail.com" required>
    </div>
    <input type="submit" class="btn btn-primary" value="Recuperar password">
</form>

<div class="links">
    <a href="<?php imprimirVolver()?>" class="btn">Volver</a>
</div>
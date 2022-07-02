<h1 class="nombre-pagina">Loguin</h1>
<p class="descripcion-pagina">Coloque su mail para recuperar el password</p>

<?php
    imprimirErrores($errores);
?>

<form class="formulario" action="#" method="POST">
    <div class="campo">
        <label for="password">Nueva password</label>
        <input type="password" name="password" id="password" placeholder="coloca tu nuevo password" required>
    </div>
    <div class="campo">
        <label for="password2">Repita la password</label>
        <input type="password" name="password2" id="password2" placeholder="repite tu password" required>
    </div>
    <input type="submit" class="btn btn-primary" value="Renovar password">
</form>


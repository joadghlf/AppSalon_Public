<h1 class="nombre-pagina">Loguin</h1>
<p class="descripcion-pagina">Inicia sesión con tus datos</p>

<?php validarResultado($resultado);
     imprimirErrores($errores);?>

<form class="formulario" action="/" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="tumail@mail.com" required>
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Password" required>
    </div>
    <input type="submit" class="btn enviar btn-primary" value="Loguear">
</form>

<div class="links">
    <a href="/crear" class="btn olvide">Crear cuenta</a>
    <a href="/olvide" class="btn olvide">Olvidé el password</a>
</div>
<div class="contenedor reestablecer">
  <?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Enter your new password</p>

<?php include_once __DIR__ . '/../templates/alertas.php' ?>

<?php if ($mostrar) { ?>

            <form action="/reestablecer" class="formulario" method="POST" >

                    <div class="campo">
                        <label for="password">Password</label>
                        <input 
                        type="password"
                        id="password"
                        placeholder="Your Password"
                        name="password"
                        >
                    </div>
                <input type="submit" class="boton" value="Save password">
            </form>
<?php } ?>

        <div class="acciones">
            <a href="/crear">Don't have an account yet? Get one</a>
            <a href="/olvide">Forgot your password?</a>
        </div>
    </div> <!-- .contenedor-sm -->
</div>
<div class="contenedor olvide">
  <?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Recover Password</p>

            <form action="/olvide" class="formulario" method="POST" >
                <div class="campo">
                    <label for="email">Email</label>
                    <input 
                    type="email"
                    id="email"
                    placeholder="Your Email"
                    name="email"
                    >
                </div>

                <input type="submit" class="boton" value="Send instructions">

            </form>

        <div class="acciones">
            <a href="/">Already have an account? Sign In</a>
            <a href="/crear">Don't have an account yet? Get one</a>
        </div>
    </div> <!-- .contenedor-sm -->
</div>
<div class="contenedor login">
  <?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Log In</p>

        <?php include_once __DIR__ . '/../templates/alertas.php' ?>

            <form action="/" class="formulario" method="POST" novalidate >
                <div class="campo">
                    <label for="email">Email</label>
                    <input 
                    type="email"
                    id="email"
                    placeholder="Your Email"
                    name="email"
                    >
                </div>

                <div class="campo">
                    <label for="password">Password</label>
                    <input 
                    type="password"
                    id="password"
                    placeholder="Your Password"
                    name="password"
                    >
                </div>

                <input type="submit" class="boton" value="Log In">

            </form>

        <div class="acciones">
            <a href="/crear">Don't have an account yet? Get one</a>
            <a href="/olvide">Forgot your password?</a>
        </div>
    </div> <!-- .contenedor-sm -->
</div>
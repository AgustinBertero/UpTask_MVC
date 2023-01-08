<div class="contenedor crear">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Create your account</p>

            <form action="/" class="formulario" method="POST" >
                <div class="campo">
                    <label for="nombre">Name</label>
                    <input 
                    type="text"
                    id="nombre"
                    placeholder="Your Name"
                    name="nombre"
                    >
                </div>
            
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

                <div class="campo">
                    <label for="password2">Repeat Password</label>
                    <input 
                    type="password"
                    id="password2"
                    placeholder="Repeat Your Password"
                    name="password2"
                    >
                </div>

                <input type="submit" class="boton" value="Create account">

            </form>

        <div class="acciones">
            <a href="/">Already have an account ? Login</a>
            <a href="/olvide">Forgot your password?</a>
        </div>
    </div> <!-- .contenedor-sm -->
</div>
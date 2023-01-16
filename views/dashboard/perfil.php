
<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php' ?>

    <form action="/perfil" class="formulario" method="POST">
        <div class="campo">
            <label for="nombre">Name</label>
            <input 
            type="text" 
            name="nombre" 
            value="<?php echo $usuario->nombre ?>"
            placeholder="Your Name">
        </div>

        <div class="campo">
            <label for="email">Email</label>
            <input 
            type="email" 
            name="email" 
            value="<?php echo $usuario->email ?>"
            placeholder="Your Email">


            <input type="submit" value="Save Changes">
        </div>
    </form>
</div>


<?php include_once __DIR__ . '/footer-dashboard.php'; ?>
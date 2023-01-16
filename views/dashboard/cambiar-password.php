
<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php' ?>

    <a href="/perfil" class="enlace">Return to profile</a>

    <form action="/perfil" class="formulario" method="POST">
        <div class="campo">
            <label for="nombre">Current Password</label>
            <input 
            type="password" 
            name="password_actual"
            placeholder="Your current password">
        </div>

        <div class="campo">
            <label for="email">New Password</label>
            <input 
            type="password" 
            name="password_nuevo"
            placeholder="Your new password">


            <input type="submit" value="Save Changes">
        </div>
    </form>
</div>


<?php include_once __DIR__ . '/footer-dashboard.php'; ?>
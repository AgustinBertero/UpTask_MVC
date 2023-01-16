<aside class="sidebar">
    <div class="contenedor-sidebar">
        <h2>UpTask </h2>

        <div class="cerrar-menu">
            <img src="build/img/cerrar.svg" alt="imagen cerrar menu" id="cerrar-menu">
        </div>
    </div>
    


    <nav class="sidebar-nav"> 
        <a class="<?php echo ($titulo === 'Projects') ? 'activo' : ''; ?>" href="/dashboard">Projects </a> 
        <a class="<?php echo ($titulo === 'Create Project') ? 'activo' : ''; ?>"  href="/crear-proyecto">Create Project </a>
        <a class="<?php echo ($titulo === 'Profile') ? 'activo' : ''; ?>"  href="/perfil">Profile</a>

    </nav>
</aside>
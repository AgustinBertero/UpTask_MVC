<?php 
foreach($alertas as $key => $alerta ):
    foreach($alerta as $mensaje):
?>

<div class="alerta <?php echo $key; ?>"> <?php echo $mensaje; ?></div> <!-- La segunda clase se genera sola con PHP -->

<?php

    endforeach;
endforeach;
?>
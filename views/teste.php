<form method="post" action="<?php echo base_url; ?>/ajax/teste">
    <input type="text" id="busca" name="busca"/>
    <input type="submit" value="enviar"/>
</form>

<?php

foreach ($name as $nome){
    echo $nome['id'];
}


?>
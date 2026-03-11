<?php 
foreach ($livres as $livre)
<li>
    <?= $livre->geTitre() ?>
    <?= $livre->geAuteur() ?>
    <?= $livre->getDatePublication() ?>
</li>

endforeach
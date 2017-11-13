<?php

/* @var $produto Models\Produto */

$produto = $data['produto'];
?>
<h2><?= $produto->getNome() ?></h2>
<p><?= nl2br($produto->getDescricao()) ?></p>

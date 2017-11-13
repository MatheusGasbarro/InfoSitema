<?php
/* @var $produto Models\Produto */
$produto = $data['produto'];
?>
<h3>Editar Produto</h3>
<form method="POST" action="">
    <input type="hidden" name="idProduto" value="<?= $produto->getIdProduto() ?>"/>
    <div class="form-group" >
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" class="form-control" value="<?= $produto->getNome() ?>" placeholder="Nome"/>
    </div>
    <div class="form-group" >
        <label for="descricao">Descrição</label>
        <textarea type="text" name="descricao" id="descricao" class="form-control" placeholder="Descrição"><?= $produto->getDescricao() ?></textarea>
    </div>
    <div class="form-group" >
        <label for="valor">Valor</label>
        <input type="number" step="any" name="valor" id="valor" class="form-control" value="<?= $produto->getValor() ?>" placeholder="Valor"/>
    </div>
    <div class="form-group" >
        <input type="checkbox" name="disponivel" id="disponivel" <?= ($produto->getDisponivel() ? 'checked=""' : '') ?>/>
        <label for="disponivel">Disponível</label>
        
    </div>
    
    <input type="submit" class="btn btn-success" value="Editar"/>
</form>
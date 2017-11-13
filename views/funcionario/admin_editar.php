<?php
/* @var $funcionario Models\Funcionario */
$funcionario = $data['funcionario'];
?>
<h3>Editar Funcionario</h3>
<form method="POST" action="">
    <input type="hidden" name="idFuncionario" value="<?= $funcionario->getIdFuncionario() ?>"/>
    <div class="form-group" >
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" class="form-control" value="<?= $funcionario->getNome() ?>" placeholder="Nome"/>
    </div>
    <div class="form-group" >
        <label for="usuario">Usuário</label>
        <input type="text" name="usuario" id="usuario" class="form-control" value="<?= $funcionario->getUsuario() ?>" placeholder="Usuário"/>
    </div>
    <div class="form-group" >
        <label for="senha">Senha</label>
        <input type="text" name="senha" id="senha" class="form-control" value="<?= $funcionario->getSenha() ?>" placeholder="Senha"/>
    </div>
    <div class="form-group" >
        <label for="cargo">Cargo</label>
        <input type="text" name="cargo" id="cargo" class="form-control" value="<?= $funcionario->getCargo() ?>" placeholder="Cargo"/>
    </div>
    
    <input type="submit" class="btn btn-success" value="Criar"/>
</form>
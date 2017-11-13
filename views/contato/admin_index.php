<h3>Contatos</h3>
<table class="table table-hover" style="width: 100%;">
    <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Mensagem</th>
        </tr>
    </thead>
    <tbody>

        <?php 
        
        /* @var $contato Models\Contato */
        foreach ($data['contatos'] as $contato) : ?>
            <tr>
                <td><?= $contato->getIdContato() ?></td>
                <td><?= $contato->getNome() ?></td>
                <td><?= $contato->getEmail() ?></td>
                <td><?= nl2br($contato->getMensagem()) ?></td>
            </tr>

        <?php endforeach; ?>
    </tbody>

</table>
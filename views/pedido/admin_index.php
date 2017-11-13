<h3>Pedidos</h3>
<table class="table table-striped" style="width: 400px;">
    <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Endereço</th>
            <th>Quantidade</th>
            <th>Item</th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($data['pedidos'] as $pedido) : ?>
            <tr>
                <td><?= $pedido->getIdPedido() ?></td>
                <td><?= $pedido->getNome() ?></td>
                <td><?= $pedido->getEndereco() ?></td>
                <td><?= $pedido->getQuantidade() ?></td>
                <td><?= $pedido->getItem()->getNome() ?></td>
                <td class="text-right">
                    <a href="<?= Lib\App::getRouter()->getUrl('pedido', 'excluir', [$pedido->getIdPedido()]) ?>" 
                       class="btn btn-sm btn-danger"
                       onclick="return confirmaExcluir()">
                        Excluir
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>

</table>

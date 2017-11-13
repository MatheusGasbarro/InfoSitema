<h3>Fazer Pedido</h3>
<form method="POST" action="">
    <div class="form-group" >
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" class="form-control" value="" placeholder="Nome"/>
    </div>
    <div class="form-group" >
        <label for="endereco">Endereço</label>
        <input type="text" name="endereco" id="endereco" class="form-control" value="" placeholder="Endereço"/>
    </div>
    <div class="form-group" >
        <label for="quantidade">Quantidade</label>
        <input type="number" step="any" name="quantidade" id="quantidade" class="form-control" value="" placeholder="Quantidade"/>
    </div>
    <div class="form-group" 
         <!--WIP-->
         <label for="item">Item</label>
        <input type="number" step="any" name="item" id="item" class="form-control" value="" placeholder="Item"/>
    </div>


    <input type="submit" class="btn btn-success" value="Pedir"/>
</form>


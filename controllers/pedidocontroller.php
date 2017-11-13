<?php

namespace Controllers;

use Lib\Controller;
use Lib\Session;
use Lib\Router;
use Lib\App;
use Models\Pedido;
use Models\Produto;
/**
 * Description of PedidoController
 *
 * @author Windows 7
 */
class PedidoController extends Controller {
    
    public function index() {
       
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
            $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_SANITIZE_NUMBER_INT);
            $item = filter_input(INPUT_POST, 'item', FILTER_SANITIZE_NUMBER_INT); 

            if ($nome == FALSE || $endereco == FALSE || $quantidade == FALSE || $item == FALSE) {
                Session::setFlash('Todos os campos são obrigatórios');
                Router::redirect(App::getRouter()->getUrl('pedido'));
            }

            $pedido = new Pedido(0, $nome, $endereco, $quantidade, Produto::getProdutoPorId($item));
            Pedido::insere($pedido);

            Session::flash('Pedido feito com sucesso.');
            Router::redirect(App::getRouter()->getUrl('pedido'));
        }
    }
    
    public function admin_index() {
        $this->data['pedidos'] = Pedido::getPedidos();
    }
           
    public function admin_excluir($id) {
        $idPedido = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        if ($idPedido == FALSE || $idPedido < 0) {
            Session::setFlash('Pedido não encontrado');
            Router::redirect(App::getRouter()->getUrl('pedido'));
        }

        Pedido::exclui($idPedido);
        Session::setFlash('Pedido excluido.');
        Router::redirect(App::getRouter()->getUrl('pedido'));
    }
}

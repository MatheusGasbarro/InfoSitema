<?php

namespace Controllers;

use Lib\Controller;
use Lib\Session;
use Lib\Router;
use Lib\App;
use Models\Produto;

/**
 * Description of ProdutoController
 *
 * @author Windows 7
 */
class ProdutoController extends Controller {

    public function index() {
        $this->data['produtos'] = Produto::getProdutos(true);
    }

    public function ver($idProduto) {
        $idProduto = filter_var($idProduto, FILTER_SANITIZE_NUMBER_INT);
        if ($idProduto != FALSE) {
            $this->data['produto'] = Produto::getProdutoPorId($idProduto);
        }
    }

    public function admin_index() {
        $this->data['produtos'] = Produto::getProdutos();
    }

    public function admin_novo() {
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
            $valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $disponivel = filter_input(INPUT_POST, 'disponivel') ? 1 : 0;

            if ($nome == FALSE || $descricao == FALSE || $valor == FALSE) {
                Session::setFlash('Todos os campos são obrigatórios');
                Router::redirect(App::getRouter()->getUrl('produto', 'novo'));
            }

            $produto = new Produto(0, $nome, $descricao, $valor, $disponivel);
            Produto::insere($produto);

            Session::flash('Produto criado com sucesso.');
            Router::redirect(App::getRouter()->getUrl('produto'));
        }
    }

    public function admin_editar($id) {
        $request = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        if ($request === 'POST') {
            $idProduto = filter_input(INPUT_POST, 'idProduto', FILTER_SANITIZE_NUMBER_INT);
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
            $valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $disponivel = filter_input(INPUT_POST, 'disponivel') ? 1 : 0;

            if ($idProduto == FALSE || $idProduto <= 0) {
                Session::setFlash('Produto não encontrado');
                Router::redirect(App::getRouter()->getUrl('produto'));
            } else if ($nome == FALSE || $descricao == FALSE || $valor == FALSE) {
                Session::setFlash('Todos os campos são obrigatórios');
                Router::redirect(App::getRouter()->getUrl('produto', 'editar', [$idProduto]));
            }

            $produto = new Produto($idProduto, $nome, $descricao, $valor, $disponivel);
            Produto::atualiza($produto);

            Session::flash('Produto atualizada com sucesso.');
            Router::redirect(App::getRouter()->getUrl('produto'));
        } else if ($request === 'GET') {
            $idProduto = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

            if ($idProduto == FALSE || $idProduto < 0) {
                Session::setFlash('Produto não encontrado');
                Router::redirect(App::getRouter()->getUrl('produto'));
            }

            $this->data['produto'] = Produto::getProdutoPorId($idProduto);
        }
    }

    public function admin_excluir($id) {
        $idProduto = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        if ($idProduto == FALSE || $idProduto < 0) {
            Session::setFlash('Produto não encontrado');
            Router::redirect(App::getRouter()->getUrl('produto'));
        }

        Produto::exclui($idProduto);
        Session::setFlash('Produto excluido.');
        Router::redirect(App::getRouter()->getUrl('produto'));
    }

}

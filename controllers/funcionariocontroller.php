<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controllers;

use Lib\App;
use Lib\Controller;
use Lib\Session;
use Lib\Router;
use Models\Funcionario;
/**
 * Description of FuncionarioController
 *
 * @author Windows 7
 */
class FuncionarioController extends Controller{
    
    public function admin_index() {
        $this->data['funcionarios'] = Funcionario::getFuncionarios();
    }
    
    public function admin_login() {
        if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
            $login = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
            $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
            
            if($login == FALSE || $senha == FALSE) {
                Session::setFlash('Todos os campos são obrigatórios');
                Router::redirect(App::getRouter()->getUrl('funcionario', 'login', [], 'admin'));
            }
            
            $funcionario = Funcionario::getByLogin($login);
            if($funcionario == NULL || password_verify($senha, $funcionario->getSenha()) == FALSE) {
                Session::setFlash('Não foi possível encontrar um usuário com os dados informados.');
            } else {
                Session::set('funcionario', $funcionario);
            }
            
            Router::redirect(App::getRouter()->getUrl('', '', [], 'admin'));
            
        }
    }
    
    public function admin_logout() {
        Session::destroy();
        Router::redirect(App::getRouter()->getUrl('', '', [], 'admin'));
    }
    
    public function admin_novo() {
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
            $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
            $cargo = filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_STRING);

            if ($nome == FALSE || $usuario == FALSE || $senha == FALSE || $cargo == FALSE) {
                Session::setFlash('Todos os campos são obrigatórios');
                Router::redirect(App::getRouter()->getUrl('funcionario', 'novo'));
            }

            $funcionario = new Funcionario(0, $nome, $usuario, $senha, $cargo);
            Funcionario::insere($funcionario);

            Session::flash('Funcionario registrado com sucesso.');
            Router::redirect(App::getRouter()->getUrl('funcionario'));
        }
    }

    public function admin_editar($id) {
        $request = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        if ($request === 'POST') {
            $idFuncionario = filter_input(INPUT_POST, 'idFuncionario', FILTER_SANITIZE_NUMBER_INT);
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
            $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
            $cargo = filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_STRING);

            if ($idFuncionario == FALSE || $idFuncionario <= 0) {
                Session::setFlash('Funcionario não encontrado');
                Router::redirect(App::getRouter()->getUrl('produto'));
            } else if ($nome == FALSE || $usuario == FALSE || $senha == FALSE || $cargo == FALSE) {
                Session::setFlash('Todos os campos são obrigatórios');
                Router::redirect(App::getRouter()->getUrl('funcionario', 'editar', [$idFuncionario]));
            }

            $funcionario = new Produto($idFuncionario, $nome, $usuario, $senha, $cargo);
            Produto::atualiza($funcionario);

            Session::flash('Funcionario atualizado com sucesso.');
            Router::redirect(App::getRouter()->getUrl('funcionario'));
        } else if ($request === 'GET') {
            $idFuncionario = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

            if ($idFuncionario == FALSE || $idFuncionario < 0) {
                Session::setFlash('Funcionario não encontrado');
                Router::redirect(App::getRouter()->getUrl('produto'));
            }

            $this->data['funcionario'] = Funcionario::getFuncionarioPorId($idFuncionario);
        }
    }

    public function admin_excluir($id) {
        $idFuncionario = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        if ($idFuncionario == FALSE || $idFuncionario < 0) {
            Session::setFlash('Produto não encontrado');
            Router::redirect(App::getRouter()->getUrl('funcionario'));
        }

        Funcionario::exclui($idFuncionario);
        Session::setFlash('Funcionario excluido.');
        Router::redirect(App::getRouter()->getUrl('funcionario'));
    }
}

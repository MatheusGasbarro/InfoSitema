<?php

namespace Controllers;

use Lib\Controller;
use Lib\Session;
use Models\Contato;

/**
 * Description of ContatoController
 *
 * @author Windows 7
 */
class ContatoController extends Controller {

    public function index() {
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === "POST") {
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_STRING);

            if ($nome == FALSE || $email == FALSE || $mensagem == FALSE) {
                Session::setFlash('Todos os campos são obrigatorios.');
            } else if (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
                Session::setFlash('Email invalido.');
            } else {
                $msg = new Contato(0, $nome, $email, $mensagem);
                Contato::insere($msg);
                
                Session::setFlash('Mensagem enviada com sucesso.');
            }
        }
    }

    public function admin_index() {
        $this->data['contatos'] = Contato::getContatos();
    }
}

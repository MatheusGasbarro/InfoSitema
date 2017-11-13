<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Models;

use Lib\DB;
use Lib\Model;
/**
 * Description of Contato
 *
 * @author Windows 7
 */
class Contato extends Model {
    
    private $idContato;
    private $nome;
    private $email;
    private $mensagem;
    
    public static function getContatos() {

        $conn = DB::getConnection();

        
        $query = 'SELECT `idContato`, `nome`, `email`, `mensagem` FROM `Contato`';
        
        $result = $conn->query($query);
        if ($result === FALSE) {
            throw new \Exception("Falha ao carregar lista de Contatos. Erro: ($conn->error)");
        }

        $contatos = [];
        while ($row = $result->fetch_assoc()) {
            $contatos[] = new Contato($row['idContato'], $row['nome'], $row['email'], $row['mensagem']);
        }

        $result->close();
        
        return $contatos;
    }
    
    /**
     * 
     * @param Contato $msg
     * @return type
     * @throws \Exception
     */
    public static function insere($msg) {
        $conn = DB::getConnection();
        
        $query = 'INSERT INTO `Contato` (`nome`, `email`, `mensagem`) VALUES (?, ?, ?)';
        $stmt = $conn->prepare($query);
        if($stmt === FALSE) {
            throw new \Exception("Falha ao preparar a query. Erro: ($conn->error)");
        }
        
        $nome = $msg->getNome();
        $email = $msg->getEmail();
        $mensagem = $msg->getMensagem();
        
        if ($stmt->bind_param('sss', $nome, $email, $mensagem) === FALSE) {
            throw new \Exception("Falha ao associar parametros. Erro: ($stmt->error)");
        }
        
        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar a query. Erro: ($stmt->error)");
        }
        
        $stmt->close();
    }
            
    function getIdContato() {
        return $this->idContato;
    }

    function getNome() {
        return $this->nome;
    }

    function getEmail() {
        return $this->email;
    }

    function getMensagem() {
        return $this->mensagem;
    }

    function setIdContato($idContato) {
        $this->idContato = $idContato;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setMensagem($mensagem) {
        $this->mensagem = $mensagem;
    }

    function __construct($idContato, $nome, $email, $mensagem) {
        $this->idContato = $idContato;
        $this->nome = $nome;
        $this->email = $email;
        $this->mensagem = $mensagem;
    }

}

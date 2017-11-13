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
 * Description of Funcionario
 *
 * @author Windows 7
 */
class Funcionario {
    
    private $idFuncionario;
    private $nome;
    private $usuario;
    private $senha;
    private $cargo;
    
    public static function getByLogin($login) {
        $conn = DB::getConnection();

        $query = 'SELECT `idFuncionario`, `nome`, `usuario`, `senha`, `cargo` FROM `Funcionario` WHERE `usuario` = ?';
        $stmt = $conn->prepare($query);
        if ($stmt === FALSE) {
            throw new \Exception("Falha ao preparar a query. Erro: ($conn->error)");
        }

        if ($stmt->bind_param('s', $login) === FALSE) {
            throw new \Exception("Falha ao associar parametros. Erro: ($stmt->error)");
        }

        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar a query. Erro: ($stmt->error)");
        }

        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $funcionario = new Funcionario($row['idFuncionario'], $row['nome'], $row['usuario'], $row['senha'], $row['cargo']);
        } else {
            $funcionario = NULL;
        }

        $result->close();
        $stmt->close();

        return $funcionario;
    
    }
    
    public static function getFuncionarios() {

        $conn = DB::getConnection();

       
        $query = 'SELECT `idFuncionario`, `nome`, `usuario`, `senha`, `cargo` FROM `Funcionario`';
        
        $result = $conn->query($query);
        if ($result === FALSE) {
            throw new \Exception("Falha ao carregar lista de Funcionarios. Erro: ($conn->error)");
        }

        $funcionarios = [];
        while ($row = $result->fetch_assoc()) {
            $funcionarios[] = new Funcionario($row['idFuncionario'], $row['nome'], $row['usuario'], $row['senha'], $row['cargo']);
        }

        $result->close();

        return $funcionarios;
    }
    
    public static function getFuncionarioPorId($funcionario) {
        $conn = DB::getConnection();

        $query = 'SELECT `idFuncionario`, `nome`, `usuario`, `senha`, `cargo` FROM `Funcionario` WHERE `idFuncionario` = ?';
        $stmt = $conn->prepare($query);
        if ($stmt === FALSE) {
            throw new \Exception("Falha ao preparar a query. Erro: ($conn->error)");
        }

        if ($stmt->bind_param('i', $funcionario) === FALSE) {
            throw new \Exception("Falha ao associar parametros. Erro: ($stmt->error)");
        }

        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar a query. Erro: ($stmt->error)");
        }

        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $funcionario = new Funcionario($row['idFuncionario'], $row['nome'], $row['usuario'], $row['senha'], $row['cargo']);
        } else {
            $funcionario = NULL;
        }

        $result->close();
        $stmt->close();

        return $funcionario;
    }
    
    /**
     * 
     * @param Funcionario $funcionario
     * @return type
     * @throws \Exception
     */
    public static function insere($funcionario) {
        $conn = DB::getConnection();

        $query = 'INSERT INTO `Funcionario` (`nome`, `usuario`, `senha`, `cargo`) VALUES (?, ?, ?, ?)';
        $stmt = $conn->prepare($query);
        if ($stmt === FALSE) {
            throw new \Exception("Falha ao preparar a query. Erro: ($conn->error)");
        }

        $nome = $funcionario->getNome();
        $usuario = $funcionario->getUsuario();
        $senha = $funcionario->getSenha();
        $cargo = $funcionario->getCargo();

        if ($stmt->bind_param('ssss', $nome, $usuario, $senha, $cargo) === FALSE) {
            throw new \Exception("Falha ao associar parametros. Erro: ($stmt->error)");
        }

        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar a query. Erro: ($stmt->error)");
        }

        $stmt->close();
    }

    /**
     * 
     * @param Funcionario $funcionario
     * @return type
     * @throws \Exception
     */
    public static function atualiza($funcionario) {
        $conn = DB::getConnection();

        $query = 'UPDATE `Funcionario` SET `nome` = ?, `usuario` = ?, `senha` = ?, `cargo` = ? WHERE `idFuncionario` = ?';
        $stmt = $conn->prepare($query);
        if ($stmt === FALSE) {
            throw new \Exception("Falha ao preparar a query. Erro: ($conn->error)");
        }

        $idFuncionario = $funcionario->getIdFuncionario();
        $nome = $funcionario->getNome();
        $usuario = $funcionario->getUsuario();
        $senha = $funcionario->getSenha();
        $cargo = $funcionario->getCargo();

        if ($stmt->bind_param('ssssi', $nome, $usuario, $senha, $cargo, $idFuncionario) === FALSE) {
            throw new \Exception("Falha ao associar parametros. Erro: ($stmt->error)");
        }

        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar a query. Erro: ($stmt->error)");
        }

        $stmt->close();
    }

    public static function exclui($idFuncionario) {
        $conn = DB::getConnection();

        $query = 'DELETE FROM `Funcionario` WHERE `idFuncionario` = ?';
        $stmt = $conn->prepare($query);
        if ($stmt === FALSE) {
            throw new \Exception("Falha ao preparar a query. Erro: ($conn->error)");
        }

        if ($stmt->bind_param('i', $idFuncionario) === FALSE) {
            throw new \Exception("Falha ao associar parametros. Erro: ($stmt->error)");
        }

        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar a query. Erro: ($stmt->error)");
        }

        $stmt->close();
    }
    
    function getIdFuncionario() {
        return $this->idFuncionario;
    }

    function getNome() {
        return $this->nome;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getSenha() {
        return $this->senha;
    }

    function getCargo() {
        return $this->cargo;
    }

    function setIdFUncionario($idFuncionario) {
        $this->idFuncionario = $idFuncionario;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function setCargo($cargo) {
        $this->cargo = $cargo;
    }

    function __construct($idFuncionario, $nome, $usuario, $senha, $cargo) {
        $this->idFuncionario = $idFuncionario;
        $this->nome = $nome;
        $this->usuario = $usuario;
        $this->senha = $senha;
        $this->cargo = $cargo;
    }

}

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
 * Description of Produto
 *
 * @author Windows 7
 */
class Produto extends Model {

    private $idProduto;
    private $nome;
    private $descricao;
    private $valor;
    private $disponivel;

    public static function getProdutos($apenasDisponivel = false) {

        $conn = DB::getConnection();

        if ($apenasDisponivel == FALSE) {
            $query = 'SELECT `idProduto`, `nome`, `descricao`, `valor`, `disponivel` FROM `Produto`';
        } else {
            $query = 'SELECT `idProduto`, `nome`, `descricao`, `valor`, `disponivel` FROM `Produto` WHERE `disponivel` = 1';
        }
        $result = $conn->query($query);
        if ($result === FALSE) {
            throw new \Exception("Falha ao carregar lista de Produtos. Erro: ($conn->error)");
        }

        $produtos = [];
        while ($row = $result->fetch_assoc()) {
            $produtos[] = new Produto($row['idProduto'], $row['nome'], $row['descricao'], $row['valor'], $row['disponivel']);
        }

        $result->close();

        return $produtos;
    }

    public static function getProdutoPorId($idProduto) {
        $conn = DB::getConnection();

        $query = 'SELECT `idProduto`, `nome`, `descricao`, `valor`, `disponivel` FROM `Produto` WHERE `idProduto` = ?';
        $stmt = $conn->prepare($query);
        if ($stmt === FALSE) {
            throw new \Exception("Falha ao preparar a query. Erro: ($conn->error)");
        }

        if ($stmt->bind_param('i', $idProduto) === FALSE) {
            throw new \Exception("Falha ao associar parametros. Erro: ($stmt->error)");
        }

        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar a query. Erro: ($stmt->error)");
        }

        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $produto = new Produto($row['idProduto'], $row['nome'], $row['descricao'], $row['valor'], $row['disponivel']);
        } else {
            $produto = NULL;
        }

        $result->close();
        $stmt->close();

        return $produto;
    }

    /**
     * 
     * @param Produto $produto
     * @return type
     * @throws \Exception
     */
    public static function insere($produto) {
        $conn = DB::getConnection();

        $query = 'INSERT INTO `Produto` (`nome`, `descricao`, `valor`, `disponivel`) VALUES (?, ?, ?, ?)';
        $stmt = $conn->prepare($query);
        if ($stmt === FALSE) {
            throw new \Exception("Falha ao preparar a query. Erro: ($conn->error)");
        }

        $nome = $produto->getNome();
        $descricao = $produto->getDescricao();
        $valor = $produto->getValor();
        $disponivel = $produto->getDisponivel();

        if ($stmt->bind_param('ssdi', $nome, $descricao, $valor, $disponivel) === FALSE) {
            throw new \Exception("Falha ao associar parametros. Erro: ($stmt->error)");
        }

        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar a query. Erro: ($stmt->error)");
        }

        $stmt->close();
    }

    /**
     * 
     * @param Produto $produto
     * @return type
     * @throws \Exception
     */
    public static function atualiza($produto) {
        $conn = DB::getConnection();

        $query = 'UPDATE `Produto` SET `nome` = ?, `descricao` = ?, `valor` = ?, `disponivel` = ? WHERE `idProduto` = ?';
        $stmt = $conn->prepare($query);
        if ($stmt === FALSE) {
            throw new \Exception("Falha ao preparar a query. Erro: ($conn->error)");
        }

        $idProduto = $produto->getIdProduto();
        $nome = $produto->getNome();
        $descricao = $produto->getDescricao();
        $valor = $produto->getValor();
        $disponivel = $produto->getDisponivel();

        if ($stmt->bind_param('ssdii', $nome, $descricao, $valor, $disponivel, $idProduto) === FALSE) {
            throw new \Exception("Falha ao associar parametros. Erro: ($stmt->error)");
        }

        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar a query. Erro: ($stmt->error)");
        }

        $stmt->close();
    }

    public static function exclui($idProduto) {
        $conn = DB::getConnection();

        $query = 'DELETE FROM `Produto` WHERE `idProduto` = ?';
        $stmt = $conn->prepare($query);
        if ($stmt === FALSE) {
            throw new \Exception("Falha ao preparar a query. Erro: ($conn->error)");
        }

        if ($stmt->bind_param('i', $idProduto) === FALSE) {
            throw new \Exception("Falha ao associar parametros. Erro: ($stmt->error)");
        }

        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar a query. Erro: ($stmt->error)");
        }

        $stmt->close();
    }

    function getIdProduto() {
        return $this->idProduto;
    }

    function getNome() {
        return $this->nome;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getValor() {
        return $this->valor;
    }

    function getDisponivel() {
        return $this->disponivel;
    }

    function setIdProduto($idProduto) {
        $this->idProduto = $idProduto;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setDisponivel($disponivel) {
        $this->disponivel = $disponivel;
    }

    function __construct($idProduto, $nome, $descricao, $valor, $disponivel) {
        $this->idProduto = $idProduto;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->valor = $valor;
        $this->disponivel = $disponivel;
    }

}

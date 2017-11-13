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
 * Description of Pedido
 *
 * @author Windows 7
 */
class Pedido extends Model {

    private $idPedido;
    private $nome;
    private $endereco;
    private $quantidade;
    private $item;

    public static function getPedidos() {

        $conn = DB::getConnection();

        $query = 'SELECT `idPedido`, `nome`, `endereco`, `quantidade`, `Produto_idProduto` FROM `Pedido`';

        $result = $conn->query($query);
        if ($result === FALSE) {
            throw new \Exception("Falha ao carregar lista de Pedidos. Erro: ($conn->error)");
        }

        $pedidos = [];
        while ($row = $result->fetch_assoc()) {
            $pedidos[] = new Pedido($row['idPedido'], $row['nome'], $row['endereco'], $row['quantidade'], Produto::getProdutoPorId($row['Produto_idProduto']));
        }

        $result->close();

        return $pedidos;
    }

    public static function getPedidoPorId($idPedido) {
        $conn = DB::getConnection();

        $query = 'SELECT `idPedido`, `nome`, `endereco`, `quantidade`, `Produto_idProduto` FROM `Pedido` WHERE `idPedido` = ?';
        $stmt = $conn->prepare($query);
        if ($stmt === FALSE) {
            throw new \Exception("Falha ao preparar a query. Erro: ($conn->error)");
        }

        if ($stmt->bind_param('i', $idPedido) === FALSE) {
            throw new \Exception("Falha ao associar parametros. Erro: ($stmt->error)");
        }

        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar a query. Erro: ($stmt->error)");
        }

        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $pedido = new Pedido($row['idPedido'], $row['nome'], $row['endereco'], $row['quantidade'], Produto::getProdutoPorId($row['Produto_idProduto']));
        } else {
            $pedido = NULL;
        }

        $result->close();
        $stmt->close();

        return $pedido;
    }

    /**
     * 
     * @param Pedido $pedido
     * @return type
     * @throws \Exception
     */
    public static function insere($pedido) {
        $conn = DB::getConnection();

        $query = 'INSERT INTO `Pedido` (`nome`, `endereco`, `quantidade`, `Produto_idProduto`) VALUES (?, ?, ?, ?)';
        $stmt = $conn->prepare($query);
        if ($stmt === FALSE) {
            throw new \Exception("Falha ao preparar a query. Erro: ($conn->error)");
        }

        $nome = $pedido->getNome();
        $endereco = $pedido->getEndereco();
        $quantidade = $pedido->getQuantidade();
        $item = $pedido->getItem()->getIdProduto();

        if ($stmt->bind_param('ssii', $nome, $endereco, $quantidade, $item) === FALSE) {
            throw new \Exception("Falha ao associar parametros. Erro: ($stmt->error)");
        }

        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar a query. Erro: ($stmt->error)");
        }

        $stmt->close();
    }
    
    public static function exclui($idPedido) {
        $conn = DB::getConnection();

        $query = 'DELETE FROM `Pedido` WHERE `idPedido` = ?';
        $stmt = $conn->prepare($query);
        if ($stmt === FALSE) {
            throw new \Exception("Falha ao preparar a query. Erro: ($conn->error)");
        }

        if ($stmt->bind_param('i', $idPedido) === FALSE) {
            throw new \Exception("Falha ao associar parametros. Erro: ($stmt->error)");
        }

        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar a query. Erro: ($stmt->error)");
        }

        $stmt->close();
    }
    
    function getIdPedido() {
        return $this->idPedido;
    }

    function getNome() {
        return $this->nome;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function getQuantidade() {
        return $this->quantidade;
    }

    /**
     * 
     * @return Produto
     */
    function getItem() {
        return $this->item;
    }

    function setIdPedido($idPedido) {
        $this->idPedido = $idPedido;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }

    function setItem($item) {
        $this->item = $item;
    }

    function __construct($idPedido, $nome, $endereco, $quantidade, $item) {
        $this->idPedido = $idPedido;
        $this->nome = $nome;
        $this->endereco = $endereco;
        $this->quantidade = $quantidade;
        $this->item = $item;
    }

}

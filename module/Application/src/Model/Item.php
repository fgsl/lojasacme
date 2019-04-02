<?php

/**
 * Modelo da classe Item
 * @filesource
 * @author Felipe Godoi
 * @copyright Copyright 2012 SERPRO
 * @package Application
 * @subpackage Model
 * @version 1.0
 */
namespace Application\Model;

class Item
{
    public $id;
    public $pedido_id;
    public $produto_id;
    public $valor;
    public $quantidade;

    // setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    public function setPedidoId($pedido_id)
    {
        $this->pedido_id = $pedido_id;
    }

    public function setProdutoId($produto_id)
    {
        $this->produto_id = $produto_id;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
    }

    // getters
    public function getId()
    {
        return $this->id;
    }

    public function getPedidoId()
    {
        return $this->pedido_id;
    }

    public function getProdutoId()
    {
        return $this->produto_id;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function getQuantidade()
    {
        return $this->quantidade;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}
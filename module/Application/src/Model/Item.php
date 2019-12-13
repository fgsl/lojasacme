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
    public $pedidoId;
    public $produtoId;
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

    public function setPedidoId($pedidoId)
    {
        $this->pedidoId = $pedidoId;
    }

    public function setProdutoId($produtoId)
    {
        $this->produtoId = $produtoId;
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
        return $this->pedidoId;
    }

    public function getProdutoId()
    {
        return $this->produtoId;
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
        $attributes = get_object_vars($this);
        $attributes['pedido_id'] = $attributes['pedidoId'];
        $attributes['produto_id'] = $attributes['produtoId'];
        unset($attributes['pedidoId']);
        unset($attributes['produtoId']);
        return $attributes;
    }
}
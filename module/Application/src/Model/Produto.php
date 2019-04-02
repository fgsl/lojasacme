<?php

namespace Application\Model;

class Produto {
	public $id;
	public $nome;
	public $valor;
	public $quantidade;
	
 	//getters
	public function getId(){
	    return $this->id;
	}
	public function getNome(){
	    return $this->nome;
	}
	public function getValor(){
	    return $this->valor;
	}
	public function getQuantidade(){
	    return $this->quantidade;
	}
	
	//setters
	
	public function setId($id){
	    $this->id = $id;
	}
	public function setNome($nome){
	    $this->nome = $nome;
	}
	public function setValor($valor){
	    $this->valor = $valor;
	}
	public function setQuantidade($quantidade){
	    $this->quantidade = $quantidade;
	}
	
public function exchangeArray(array $data) {
		$this->id = isset ( $data ['id'] ) ? $data ['id'] : null;
		$this->nome = isset ( $data ['nome'] ) ? $data ['nome'] : null;
		$this->valor = isset ( $data ['valor'] ) ? $data ['valor'] : null;
		$this->quantidade = isset ( $data ['quantidade'] ) ? $data ['quantidade'] : null;
	}
public function toArray() {
    return get_object_vars ( $this );
	}
}   
<?php

namespace Application\Model;

class Produto {
    public $codigo;
	public $id;
	public $nome;
	public $valor;
	public $quantidade;	 
	
	//getters
	public function getCodigo(){
	    return $this->codigo;
	}
	public function setCodigo(){
	    $this->codigo = $codigo;
	}
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
        $this->codigo= (isset ( $data ['codigo'] ) ? $data ['codigo'] : null);
		$this->id = (isset ( $data ['id'] ) ? $data ['id'] : null);
		$this->nome = (isset ( $data ['nome'] ) ? $data ['nome'] : null);
		$this->valor = (isset ( $data ['valor'] ) ? $data ['valor'] : null);
		$this->quantidade = (isset ( $data ['quantidade'] ) ? $data ['quantidade'] : null);
	}
public function toArray() {
    $atributos = get_object_vars( $this );
    unset($atributos['codigo']);
    $array = []; 
    foreach($atributos as $atributo => $valor){
        if (!empty($valor) || $valor === 0) {
            $array[$atributo] = $valor;
        }
    }
    return $array;
}

}
###Produto

<blockquote>
  <p>
  Etá referente principalmente sobre os ID, Códigos, Nomes, Quantidade e Valor de cada produto referente dentro do site.
  </p>
  <p>Ele acaba ajudando todos os outros .php pois ele junta varias coisas dentro de apenas um código.</p>
</blockquote>

```

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
	public function setCodigo($codigo){
	    $this->codigo = $codigo;
	}

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

```
<?php

namespace Application\Model;

class Produto {
	public $id;
	public $nome;
	public $valor;
	public $quantidade;
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
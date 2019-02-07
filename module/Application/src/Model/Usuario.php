<?php
/**
 * Modelo da classe Usuario 
 * @filesource
 * @author Felipe Godoi
 * @copyright Copyright 2012 SERPRO
 * @package Application
 * @subpackage Model
 * @version 1.0
 */
namespace Application\Model;

class Usuario{
	private $id;
	private $email;
	private $cpf;
	private $senha;
	private $userArray;
	
	//getters
	public function getId(){
	return $this->id;
	}
	public function getEmail(){
	return $this->email;
	}
	public function getCpf(){
	return $this->cpf;
	}
	public function getSenha(){
	return $this->senha;
	}

	//setters

	public function setId($id){
	$this->id = $id; 
	}
	public function setEmail($email){
	$this->email = $email; 
	}
	public function setCpf($cpf){
	$this->cpf = $cpf;
	}
	public function setSenha($senha){
	$this->senha = $senha;
	}
	
	public function toArray(){
	return $this->userArray = array(
	"id" => $this->getId(),
	"email" => $this->getEmail(),
	"cpf" => $this->getCpf(),
	"senha" => $this->getSenha(),
	);
	}
	
}
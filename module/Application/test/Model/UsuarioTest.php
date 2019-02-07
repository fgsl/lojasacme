<?php

namespace ApplicationTest\Model;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Application\Model\Usuario;

class UsuarioTest extends AbstractHttpControllerTestCase{

	public function testFail(){

	$usuario = new Usuario();
	$usuario->setId(123456789);
	$usuario->setEmail('teste@hotmail.com');
	$usuario->setCpf(45678912396);
	$usuario->setSenha('senha');

	$this->assertEquals(123456789,$usuario->getId());	
	$this->assertEquals('teste@hotmail.com',$usuario->getEmail());	
	$this->assertEquals(45678912396,$usuario->getCpf());	
	$this->assertEquals('senha',$usuario->getSenha());	
	}

}

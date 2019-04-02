<?php

namespace Application\Model;  // Nome = modulo + caminho do diretório//

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;	//caminho dos arquivos usados//
use Application\Model\Usuario;	
use Application\Model\UsuarioTable;
use Fgsl\Mock\Db\Adapter\Mock as Adapter;
use Fgsl\Mock\Db\TableGateway\Mock as TableGateway;
use Fgsl\Mock\Db\Adapter\Driver\Mock as Driver;
use Zend\Db\Sql\Where;
use phpDocumentor\Reflection\Types\This;

class UsuarioTableTest extends AbstractHttpControllerTestCase{		//extends = herança//
	
private $usuario;	//atributos//
private $driver;
private $adapter;
private $tableGateway;
private $usuarioTable;
private $where;

public function setUp(){
	$this->usuario = new Usuario();
	$this->driver = new Driver();
	$this->adapter = new Adapter($this->driver);
	$this->tableGateway = new TableGateway("usuarios", $this->adapter);
	$rows = [$this->usuario];
	$this->tableGateway->setMockResultRows($rows);
	$this->usuarioTable = new UsuarioTable($this->tableGateway);
	$this->where = new Where();
}

public function setUsuario(){
	$this->usuario->setId(123456789);
	$this->usuario->setEmail('teste@gmail.com');
	$this->usuario->setCpf(987654321);
	$this->usuario->setSenha('senha');
}

public function testToArray(){
	$this->assertContainsOnly('array', [$this->usuario->toArray()]);
}

public function testInsert(){
	$this->setUsuario();
	$this->assertEquals(1,$this->usuarioTable->insert($this->usuario));
}

public function testUpdate(){
	$this->where->equalTo('id', 1);
	$this->assertEquals(1,$this->usuarioTable->update($this->usuario, $this->where));
}

public function testDelete(){
	$this->setUsuario();
	$this->where->equalTo('id', 1);
	
	$usuario2 = new Usuario();
	$usuario2->setId(1);
	$usuario2->setEmail(1);
	$usuario2->setCpf(1);
	$usuario2->setSenha(1);
	
	$this->assertEquals(1,$this->usuarioTable->delete($this->usuario, $this->where));
	$this->assertEquals(1,$this->usuarioTable->delete($usuario2, $this->where));
}

public function testGetAll(){
	$this->assertCount(1,$this->usuarioTable->getAll($this->where));
}

public function testGetOne(){
	$this->assertObjectHasAttribute("id", $this->usuarioTable->getOne(1));	
}
}
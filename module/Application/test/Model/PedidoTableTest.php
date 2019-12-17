<?php
namespace Application\Model;

use Fgsl\Mock\Db\Adapter\Mock as Adapter;
use Fgsl\Mock\Db\Adapter\Driver\Mock as Driver;
use Fgsl\Mock\Db\TableGateway\Mock as TableGateway;
use Zend\Db\Sql\Where;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class PedidoTableTest extends AbstractHttpControllerTestCase
{
    private $pedidoTable;
    private $pedido;
    private $driver;
    private $adapter;
    private $tableGateway;
    private $where;

    public function setUp():void
    {
        $this->pedido = new Pedido();
        $this->driver = new Driver();
        $this->adapter = new Adapter($this->driver);
        $this->tableGateway = new TableGateway("pedido", $this->adapter);
        $rows = [
            $this->pedido
        ];
        $this->tableGateway->setMockResultRows($rows);
        $this->pedidoTable = new PedidoTable($this->tableGateway);
        $this->where = new Where();
    }

    public function testToArray()
    {
        $this->assertContainsOnly('array', [
            $this->pedido->toArray()
        ]);
    }

    public function testInsert()
    {
        $this->assertEquals(1, $this->pedidoTable->insert($this->pedido));
        $this->assertNotNull($this->pedidoTable->insert($this->pedido));
    }

    public function testUpdate()
    {
        $this->where->equalTo('id', 1);
        $this->assertEquals(1, $this->pedidoTable->update($this->pedido, $this->where));
    }

    public function testDelete()
    {
        $this->where->equalTo('id', 1);

        $this->pedido->setId(1);

        $pedido2 = new Pedido();
        $pedido2->setId(2);

        $this->assertEquals(1, $this->pedidoTable->delete($this->pedido, $this->where));
        $this->assertEquals(1, $this->pedidoTable->delete($pedido2, $this->where));
    }

    public function testGetAll()
    {
        $this->assertCount(1, $this->pedidoTable->getAll($this->where));
    }

    public function testGetOne()
    {
        $this->assertObjectHasAttribute("id", $this->pedidoTable->getOne(1));
        $this->assertObjectHasAttribute("codigo", $this->pedidoTable->getOne(1));
    }
}
?>
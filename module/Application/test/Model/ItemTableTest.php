<?php
namespace Application\Model;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Application\Model\Item;
use Application\Model\ItemTable;
use Fgsl\Mock\Db\Adapter\Mock as Adapter;
use Fgsl\Mock\Db\TableGateway\Mock as TableGateway;
use Fgsl\Mock\Db\Adapter\Driver\Mock as Driver;
use Zend\Db\Sql\Where;

class ItemTableTest extends AbstractHttpControllerTestCase
{
    private $itemTable;
    private $item;
    private $driver;
    private $adapter;
    private $tableGateway;
    private $where;

    public function setUp():void
    {
        $this->item = new Item();
        $this->driver = new Driver();
        $this->adapter = new Adapter($this->driver);
        $this->tableGateway = new TableGateway("item", $this->adapter);
        $rows = [
            $this->item
        ];
        $this->tableGateway->setMockResultRows($rows);
        $this->itemTable = new ItemTable($this->tableGateway);
        $this->where = new Where();
    }

    public function testToArray()
    {
        $this->assertContainsOnly('array', [
            $this->item->toArray()
        ]);
    }

    public function testInsert()
    {
        $this->assertEquals(1, $this->itemTable->insert($this->item));
    }

    public function testUpdate()
    {
        $this->where->equalTo('id', 1);
        $this->assertEquals(1, $this->itemTable->update($this->item, $this->where));
    }

    public function testDelete()
    {
        $this->where->equalTo('id', 1);

        $this->item->setId(1);

        $item2 = new Item();
        $item2->setId(2);

        $this->assertEquals(1, $this->itemTable->delete($this->item, $this->where));
        $this->assertEquals(1, $this->itemTable->delete($item2, $this->where));
    }

    public function testGetAll()
    {
        $this->assertCount(1, $this->itemTable->getAll($this->where));
    }

    public function testGetOne()
    {
        $this->assertObjectHasAttribute("id", $this->itemTable->getOne(1));
        $this->assertObjectHasAttribute("pedidoId", $this->itemTable->getOne(1));
        $this->assertObjectHasAttribute("produtoId", $this->itemTable->getOne(1));
        $this->assertObjectHasAttribute("quantidade", $this->itemTable->getOne(1));
        $this->assertObjectHasAttribute("valor", $this->itemTable->getOne(1));
    }
}
?>
<?php
namespace Application\Model;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Application\Model\Produto;
use Application\Model\ProdutoTable;
use Fgsl\Mock\Db\Adapter\Mock as Adapter;
use Fgsl\Mock\Db\TableGateway\Mock as TableGateway;
use Fgsl\Mock\Db\Adapter\Driver\Mock as Driver;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Select;
use Fgsl\Mock\Db\Platform\Mock;

class ProdutoTableTest extends AbstractHttpControllerTestCase
{

    private $produtoTable;
    private $produto;
    private $driver;
    private $adapter;
    private $tableGateway;
    private $where;

    public function setUp():void
    {
        $this->produto = new Produto();
        $this->driver = new Driver();
        $this->adapter = new Adapter($this->driver);
        $this->tableGateway = new TableGateway("produto", $this->adapter);
        $rows = [
            $this->produto
        ];
        $this->tableGateway->setMockResultRows($rows);
        $this->produtoTable = new ProdutoTable($this->tableGateway);
        $this->where = new Where();
    }
    
    public function testToArray()
    {
        $this->assertContainsOnly('array', [
            $this->produto->toArray()
        ]);
    }

    public function testInsert()
    {
        $this->assertEquals(1, $this->produtoTable->insert($this->produto));
        $this->assertNotNull($this->produtoTable->insert($this->produto));
    }

    public function testUpdate()
    {
        $this->where->equalTo('id', 1);
        $this->assertEquals(1, $this->produtoTable->update($this->produto, $this->where));
    }

    public function testDelete()
    {
        $this->where->equalTo('id', 1);

        $this->produto->setId(1);

        $produto2 = new Produto();
        $produto2->setId(2);

        $this->assertEquals(1, $this->produtoTable->delete($this->produto, $this->where));
        $this->assertEquals(1, $this->produtoTable->delete($produto2, $this->where));
    }

    public function testGetAll()
    {
        $this->assertCount(1, $this->produtoTable->getAll());
    }

    public function testGetOne()
    {
        $this->assertObjectHasAttribute("id", $this->produtoTable->getOne(1));
    }
        
/**
 * TODO melhorar componente de Mock para emular o selectWith
 *
         
    public function testGetLastCodigo()
    {
        $select = new Select();
        $select->from('produtos')
        ->columns([ 'codigo' => new \Zend\Db\Sql\Expression('max(id)')]);
        
        echo $select->getSqlString(new Mock());
        
        $this->assertEquals('integer',gettype($this->produtoTable->getLastCodigo()));
    }
**/        
}
?>
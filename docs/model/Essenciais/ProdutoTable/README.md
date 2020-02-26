###ProdutoTable

```

class ProdutoTable
{

    /**
     *
     * @var TableGatewayInterface
     */
    protected $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function insert(Produto $produto)
    {
        $set = $produto->toArray();
        return $this->tableGateway->insert($set);
    }

    public function update(Produto $produto, $where)
    {
        $set = $produto->toArray();
        return $this->tableGateway->update($set, $where);
    }

    public function delete($where)
    {
        return $this->tableGateway->delete($where);
    }
    
    public function getLastCodigo()
    {
        $select = new Select();
        $select->from('produtos')
        ->columns([ 'codigo' => new \Zend\Db\Sql\Expression('max(id)')]);
        
        $resultSet = $this->tableGateway->selectWith($select);

        return $resultSet->current()->codigo;        
    }

    /**
     *
     * @param
     *            array | string | Where $where
     */
    public function getAll($where = null)
    {
        return $this->tableGateway->select($where);
    }
    
    public function getOne($id)
    {
        $where = [
            'id' => $id
        ];
        $rowSet = $this->getAll($where);
        if ($rowSet->count() == 0 || $rowSet->current() == null) {
            return new Produto();
        }
        return $rowSet->current();
    }
}

```


###ItemTable

<blockquote>
  <p>
  Ele usa os dados ja fornecidos para não serem perdidos. Guardando em uma fonte onde ele pode guardar, mesmo que o computador desligue não será perdido os dados realizados dentro dele.
  </p>

```php
class ItemTable {
	/**
	 *
	 * @var TableGatewayInterface
	 */
	protected $tableGateway;
	public function __construct(TableGatewayInterface $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function insert(Item $item) {
		$set = $item->toArray ();
		return $this->tableGateway->insert ( $set );
	}
	public function update(Item $item, $where)
	{
		$set = $item->toArray ();
		return $this->tableGateway->update ( $set, $where );
	}
	public function delete($where) {
	    return $this->tableGateway->delete ( $where );
	}

	/**
	 *
	 * @param
	 *        	array | string | Where $where
	 */
	public function getAll($where = null) {
		return $this->tableGateway->select ( $where );
	}
	public function getOne($codigo) {
		$where = [
				'codigo' => $codigo
		];
		$rowSet = $this->getAll ( $where );
		if ($rowSet->count () == 0) {
			return new Item ();
		}
		return $rowSet->current ();
	}
	
}
```

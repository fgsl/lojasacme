<?php

/**
 * Modelo da classe ProdutoTable
* @filesource
* @author Felipe Godoi
* @copyright Copyright 2012 SERPRO
* @package Application
* @subpackage Model
* @version 1.0
*/
namespace Application\Model;

use Zend\Db\TableGateway\TableGatewayInterface;

class ProdutoTable {
	/**
	 *
	 * @var TableGatewayInterface
	 */
	protected $tableGateway;
	public function __construct(TableGatewayInterface $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function insert(Produto $produto) {
		$set = $produto->toArray ();
		$this->tableGateway->insert ( $set );
	}
	public function update(Produto $produto, $where) {
		$set = $produto->toArray ();
		$this->tableGateway->update ( $set, $where );
	}
	public function delete($where) {
		$this->tableGateway->delete ( $where );
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
		if ($rowset->count () == 0) {
			return new Produto ();
		}
		return $rowSet->current ();
	}
}

<?php

namespace Application\Model;

use Interop\Container\ContainerInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Db\ResultSet\ResultSet;
class ProdutoTableFactory implements FactoryInterface 
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
		$adapter = $container->get('DbAdapter');
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new Produto());
		$tableGateway = new TableGateway('produtos', $adapter, null, $resultSet);
		return new ProdutoTable($tableGateway);
	}
}
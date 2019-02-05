<?php

namespace Application\Model;

use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\ProdutoTable;
use Interop\Container\ContainerInterface;
class ProdutoTableFactory implements FactoryInterface 
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
		$adapter = $container->get('DbAdapter');
		$tableGateway = new TableGateway('produtos', $adapter);
		return new ProdutoTable($tableGateway);
	}
}

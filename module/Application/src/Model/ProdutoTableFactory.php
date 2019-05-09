<?php

namespace Application\Model;

use Interop\Container\ContainerInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\Factory\FactoryInterface;
class ProdutoTableFactory implements FactoryInterface 
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
		$adapter = $container->get('DbAdapter');
		$tableGateway = new TableGateway('produtos', $adapter);
		return new ProdutoTable($tableGateway);
	}
}
<?php

namespace Application\Model;

use Interop\Container\ContainerInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\Factory\FactoryInterface;
class UsuarioTableFactory implements FactoryInterface 
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
		$adapter = $container->get('DbAdapter');
		$tableGateway = new TableGateway('usuarios', $adapter);
		return new UsuarioTable($tableGateway);
	}
}
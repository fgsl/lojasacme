<?php
namespace Application\Controller;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Session\SessionManager;

class EstoqueControllerFactory implements FactoryInterface
{
    
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    
    {
        $sessionManager = new SessionManager();
        $sessionManager->start();
        return new EstoqueController($container);
    }
}
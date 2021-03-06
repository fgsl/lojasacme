<?php
namespace Application\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Session\SessionManager;

class CarrinhoControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)

    {
        $sessionManager = new SessionManager();
        $sessionManager->start();
        return new CarrinhoController($container);
    }
}
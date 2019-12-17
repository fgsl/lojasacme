<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace ApplicationTest\Controller;

use Zend\ServiceManager\ServiceManager;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Application\Controller\EstoqueController;
use Zend\Session\SessionManager;

class EstoqueControllerTest extends AbstractHttpControllerTestCase
{

    public function setUp():void
    {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
        $this->setApplicationConfig(include __DIR__ . '/../../../../config/mock.config.php');
        parent::setUp();
    }

    public function testDefaultAction()
    {
        $this->assertTrue($this->getApplication()
            ->getServiceManager()
            ->has(SessionManager::class));
        $this->dispatch('/estoque', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('application');
        $this->assertControllerName(EstoqueController::class);
        $this->assertControllerClass('EstoqueController');
    }

    public function testIndexAction()
    {
        $this->dispatch('/estoque/Index', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('application');
        $this->assertControllerName(EstoqueController::class);
        $this->assertControllerClass('EstoqueController');
    }

    public function testLoginAction()
    {
        $this->dispatch('/estoque/Login', 'GET');
        $this->assertResponseStatusCode(302);
        $this->assertModuleName('application');
        $this->assertControllerName(EstoqueController::class);
        $this->assertControllerClass('EstoqueController');
    }

    /**
     *
     * @todo https://github.com/fgsl/lojasacme/issues/73
     *       public function testLogoutAction()
     *       {
     *       $this->dispatch('/estoque/Logout', 'GET');
     *       $this->assertResponseStatusCode(302);
     *       $this->assertModuleName('application');
     *       $this->assertControllerName(EstoqueController::class);
     *       $this->assertControllerClass('EstoqueController');
     *       }
     */
    
    public function testManterProdutoAction()
    {
        $this->dispatch('/estoque/ManterProduto', 'GET');
        $this->assertResponseStatusCode(302);
        $this->assertModuleName('application');
        $this->assertControllerName(EstoqueController::class);
        $this->assertControllerClass('EstoqueController');
    }

}
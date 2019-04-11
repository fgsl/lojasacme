<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ApplicationTest\Controller;

use Application\Controller\IndexController;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Application\Controller\CarrinhoController;

class CarrinhoControllerTest extends AbstractHttpControllerTestCase
{
    private $carrinho;
    public function setUp()
    {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
        $this->carrinho= new CarrinhoController();
        $this->setApplicationConfig(include __DIR__ . '/../../../../config/mock.config.php');

        parent::setUp();
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/carrinho', 'GET');
        $this->assertResponseStatusCode(200); // se o retorno do método for um ViewModel, é 200, se for um redirect, é 302
        $this->assertModuleName('application');
        $this->assertControllerName(CarrinhoController::class); // as specified in router's controller name alias
        $this->assertControllerClass('CarrinhoController');
        $this->assertMatchedRouteName('carrinho');
    }
    
    public function testComprarAction(){
        $this->dispatch('/carrinho/comprar', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('application');
        $this->assertControllerName(CarrinhoController::class);
        $this->assertControllerClass('CarrinhoController');
    }
    
    public function testIndexAction(){
        $this->dispatch('/carrinho/index', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('application');
        $this->assertControllerName(CarrinhoController::class);
        $this->assertControllerClass('CarrinhoController');
    }
    
    public function testExcluirAction(){
        $this->dispatch('/carrinho/excluir', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('application');
        $this->assertControllerName(CarrinhoController::class);
        $this->assertControllerClass('CarrinhoController');
    }
}
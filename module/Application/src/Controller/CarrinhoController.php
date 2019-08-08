<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Model\Produto;
use Zend\View\Model\ViewModel;
use Zend\Http\Header\Range;
use Application\Model\ProdutoTable;
use Interop\Container\ContainerInterface;
/* use Zend\Db\TableGateway\TableGateway;
 use Fgsl\Mock\Db\Adapter\Mock as Adapter;
 use Fgsl\Mock\Db\Adapter\Driver\Mock as Driver;
 */
class CarrinhoController extends AbstractActionController
{
    /**
     * @var ContainerInterface
     */
    private $container;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    /* Página do carrinho de compras */
    public function comprarAction()
    {
        $_SESSION['ultimaPagina'] = __METHOD__;
        $mensagem = '';
        if (! isset($_SESSION['carrinho'])) { // se a seção não esta iniciada
            $_SESSION['carrinho'] = array();    // a seção recebe array()
        }
        $carrinho = $_SESSION['carrinho'];
        if (! is_null($this->params('id'))) {
            $id = (int) $this->params('id');
            $incluindo = FALSE;  //produto não selecionado
            foreach ($carrinho as $produto) { // laço que detecta se os produtos tem id ou id repetido
                if (isset($produto['id'])) { //continua se tiver id
                    if ($produto['id'] == $id) {  //continua se tiver id repetido
                        $incluindo = TRUE;  //produto selecionado
                        $mensagem = 'Produto já selecionado';
                        break;
                    }
                 }
            }
            if (! $incluindo) { // se incluindo for falso
                $produtoTable = $this->container->get('ProdutoTable');
                $item = $produtoTable->getOne($id)->getArrayCopy();
                $item['quantidade'] = 1;
                $carrinho[] = $item;
                $_SESSION['carrinho'] = $carrinho;
            }
        }
        
        $viewModel = $viewModel = new ViewModel();
        
        $viewModel->mensagem = $mensagem;
        $viewModel->itens =  $carrinho;
        return $viewModel;        
    }

    public function indexAction()
    {
        $_SESSION['ultimaPagina'] = __METHOD__;
        return $this->redirect()->toRoute('carrinho',['action'=>'comprar']);
    }

    public function excluirAction()
    {       
        $_SESSION['ultimaPagina'] = __METHOD__;
        $id = (int) $this->params('id');
        
        if (empty($id)) {
            return $this->redirect()->toRoute('carrinho');
        }
        foreach ($_SESSION['carrinho'] as $chave => $produto) {
            if ($produto['id'] == $id) {
                unset($_SESSION['carrinho'][$chave]);
                break;
            }
        }
        return $this->redirect()->toRoute('carrinho');
    }
}
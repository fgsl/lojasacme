<?php
namespace Application\Controller;

use Interop\Container\ContainerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CarrinhoController extends AbstractActionController
{

    /**
     *
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
        if (! isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = array();
        }
        $carrinho = $_SESSION['carrinho'];
        if (! is_null($this->params('id'))) {
            $id = (int) $this->params('id');
            $incluindo = FALSE;
            foreach ($carrinho as $produto) {
                if (isset($produto['id'])) {
                    if ($produto['id'] == $id) {
                        $incluindo = TRUE;
                        $mensagem = 'Produto já selecionado';
                        break;
                    }
                }
            }
            if (! $incluindo) {
                $produtoTable = $this->container->get('ProdutoTable');
                $item = $produtoTable->getOne($id)->getArrayCopy();
                $item['quantidade'] = 1;
                $carrinho[$id] = $item;
                $_SESSION['carrinho'] = $carrinho;
            }
        }

        $viewModel = $viewModel = new ViewModel();

        $viewModel->mensagem = $mensagem;
        $viewModel->itens = $carrinho;
        return $viewModel;
    }

    public function editarAction()
    {
        $id = $this->params('id');
        $produtoSelecionado = $_SESSION['carrinho'][$id];
        return new ViewModel(['produtoSelecionado' => $produtoSelecionado]);
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

    public function alterarAction()
    {
        /* Alteração de quantidade de um item do carrinho*/
        $id = (int)$this->request->getPost('id');
        
        if (! is_numeric($id) || is_null($id))
        {
            $this->redirect()->toRoute('carrinho');
            exit;
        }
        $quantidade = (int) $this->request->getPost('quantidade');
        foreach ($_SESSION['carrinho'] as $chave => $produto)

        {
            if (isset($produto['id']))
            {
                If ($produto['id'] == $id )
                {
                    $_SESSION['carrinho'][$chave]['quantidade']= $quantidade;
                    break;
                }
            }
        }
        $this->redirect()->toRoute('carrinho');
    }
}
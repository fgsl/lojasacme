<?php
namespace Application\Controller;

use Interop\Container\ContainerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\Pedido;
use Application\Model\Item;

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

    public function editarAction()
    {
        $id = $this->params('id');
        $produtoSelecionado = $_SESSION['carrinho'][$id];
        return new ViewModel(['produtoSelecionado' => $produtoSelecionado]);
    }

    public function alterarAction()
    {
        /* Alteração de quantidade de um item do carrinho*/
        $id = (int)$this->request->getPost('id');
        
        if (is_null($id))
        {
            return $this->redirect()->toRoute('carrinho');
        }
        //validação do formulário
        $quantidade = $this->request->getPost('quantidade');
        if (!is_numeric($quantidade))
        {
            return $this->redirect()->toRoute('carrinho');
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
        return $this->redirect()->toRoute('carrinho');
    }
    
    /* Fechamento da compra */
    /* Fechamento da compra */
    public function fecharAction()
    {
        if (!isset($_SESSION['cliente']))
        {
            return $this->redirect()->toRoute('application',['action' => 'acessar']);
        }
        return new ViewModel();
    }
    
    /* Grava o pedido de compra */
    public function gravarCompraAction()
    {
        $formaEscolhida = $this->request->getPost('formaPagamento');
        $formasPagamento = array('boleto'=>'Boleto
Bancário','cartao'=>'Cartão de Crédito');
        $codigo = mt_rand(10000,99999);
        $pedidoTable = $this->container->get('PedidoTable'); 
        $pedido = new Pedido();
        $pedido->setCodigo($codigo);
        $idPedido = $pedidoTable->insert($pedido);
        $itens = $_SESSION['carrinho'];
        foreach ($itens as $itemDoCarrinho)
        {
            $item = new Item();
            $item->setPedidoId($idPedido);
            $item->setProdutoId($itemDoCarrinho['id']);
            $item->setQuantidade($itemDoCarrinho['quantidade']);
            $item->setValor($itemDoCarrinho['valor']);
            
            /* $item->setProdutoId(array('produto_id'=>$item['id']));
            $item->setQuantidade(array('quantidade'=>$item['quantidade']));
            $item->setValor(array('valor'=>$item['valor'])); */
            
            $novoItem = $this->container->get('ItemTable');
            $novoItem->insert($item);
        }
        unset($_SESSION['carrinho']);
        $mensagem = "O pedido $codigo pago com{$formasPagamento[$formaEscolhida]} foi finalizado com sucesso";
        return new ViewModel(['mensagem' => $mensagem]);
    }
    
}
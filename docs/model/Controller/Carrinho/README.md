###CarrinhoController

* No CarrinhoController está referente em principalmente nas compras das coisa, incluir, excluir, editar, alterar, gravar a comprar (Gravar o id do item) e os detalhes que estão dentro no item.

```

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
        $sessionManager = $this->container->get(SessionManager::class);
        $sessionManager->start();
    }

    // Página do carrinho de compras
    public function comprarAction()
    {
        $sessionManager = $this->container->get(SessionManager::class);
        $sessionManager->getStorage()->ultimaPagina = __METHOD__;

        $mensagem = '';
        if ( isset($sessionManager->getStorage()->mensagem)) {
            $mensagem = $sessionManager->getStorage()->mensagem;
            unset($sessionManager->getStorage()->mensagem);
        }        
        if (! isset($sessionManager->getStorage()->carrinho)) {
            $sessionManager->getStorage()->carrinho = array();
        }
        $carrinho = $sessionManager->getStorage()->carrinho;
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
                $item = $produtoTable->getOne($id)->toArray();
                $item['quantidade'] = 1;
                $carrinho[$id] = $item;
                $sessionManager->getStorage()->carrinho = $carrinho;
            }
        }

        $viewModel = new ViewModel();

        $viewModel->mensagem = $mensagem;
        $viewModel->itens = $carrinho;
        $viewModel->storage = $sessionManager->getStorage();
        return $viewModel;
    }

    public function indexAction()
    {
        $sessionManager = $this->container->get(SessionManager::class);
        $sessionManager->getStorage()->ultimaPagina = __METHOD__;

        return $this->redirect()->toRoute('carrinho', [
            'action' => 'comprar'
        ]);
    }

    public function excluirAction()
    {
        $sessionManager = $this->container->get(SessionManager::class);
        $sessionManager->getStorage()->ultimaPagina = __METHOD__;

        $id = (int) $this->params('id');

        if (empty($id)) {
            return $this->redirect()->toRoute('carrinho');
        }
        foreach ($sessionManager->getStorage()->carrinho as $chave => $produto) {
            if ($produto['id'] == $id) {
                unset($sessionManager->getStorage()->carrinho[$chave]);
                break;
            }
        }
        return $this->redirect()->toRoute('carrinho');
    }

    public function editarAction()
    {
        $sessionManager = $this->container->get(SessionManager::class);
        $id = $this->params('id');
        $produtoSelecionado = $sessionManager->getStorage()->carrinho[$id];
        $viewModel = new ViewModel(['produtoSelecionado' => $produtoSelecionado]);
        $viewModel->storage = $sessionManager->getStorage();
        return $viewModel;
    }

    public function alterarAction()
    {
        // Alteração de quantidade de um item do carrinho
        $sessionManager = $this->container->get(SessionManager::class);
        $id = (int) $this->request->getPost('id');

        if (is_null($id)) {
            return $this->redirect()->toRoute('carrinho');
        }
        // validação do formulário
        $quantidade = $this->request->getPost('quantidade');
        if (! is_numeric($quantidade)) {
            return $this->redirect()->toRoute('carrinho');
        }
        $quantidade = (int)$quantidade;
        foreach ($sessionManager->getStorage()->carrinho as $chave => $produto){
            if ($chave == $id) {                
                $sessionManager->getStorage()->carrinho[$chave]['quantidade'] = $quantidade;
                    break;
                }
        }
        return $this->redirect()->toRoute('carrinho');
    }

    // Fechamento da compra
    public function fecharAction()
    {        
        $sessionManager = $this->container->get(SessionManager::class);
        if (!isset($sessionManager->getStorage()->cliente)){
            return $this->redirect()->toRoute('application',['action' => 'acessar']);
        }else if(count($sessionManager->getStorage()->carrinho) == 0){
            $sessionManager->getStorage()->mensagem = "Selecione ao menos um produto para fechar a compra.";
            return $this->redirect()->toRoute('carrinho');
        }
        return new ViewModel();
    }  

    // Grava o pedido de compra
    public function gravarCompraAction()
    {
        $sessionManager = $this->container->get(SessionManager::class);    
        $formaEscolhida = $this->request->getPost('formaPagamento');
        $formasPagamento = array(
            'boleto' => 'Boleto Bancário',
            'cartao' => 'Cartão de Crédito'
        );
        $codigo = mt_rand(10000, 99999);
        $pedidoTable = $this->container->get('PedidoTable');
        $pedido = new Pedido();
        $pedido->setCodigo($codigo);
        $idPedido = $pedidoTable->insert($pedido);
        $itens = $sessionManager->getStorage()->carrinho;
        foreach ($itens as $itemDoCarrinho){
            $item = new Item();
            $item->setPedidoId($idPedido);
            $item->setProdutoId($itemDoCarrinho['id']);
            $item->setQuantidade($itemDoCarrinho['quantidade']);
            $item->setValor($itemDoCarrinho['valor']);

            $novoItem = $this->container->get('ItemTable');
            $novoItem->insert($item);
        }
        unset($sessionManager->getStorage()->carrinho);
        $mensagem = "O pedido $codigo pago com {$formasPagamento[$formaEscolhida]} foi finalizado com sucesso";
        return new ViewModel(['mensagem' => $mensagem]);
    }
    
    public function detalhesAction()
    {
        $codigo = $this->params('id');
        
        $produtoTable = $this->container->get('ProdutoTable');
        $item = $produtoTable->getOne($codigo)->toArray();
        
        $lista = [
            $codigo - 3,
            $codigo - 2,
            $codigo - 1,
            $codigo + 1,
            $codigo + 2,
            $codigo + 3,
        ];
        
        $where = new Where();
        $where->in("id", $lista);
        
        $outrosProdutos = $produtoTable->getAll($where)->toArray();
        
        $viewModel = new ViewModel(['item' => $item, 'produtos' => $outrosProdutos]); 
        return $viewModel;
    }
}

```


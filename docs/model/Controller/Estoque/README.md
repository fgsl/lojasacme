###EstoqueController

* O EstoqueController é responsavel em excluir, incluir, alterar, selecionar, em manter o produto.

```

class EstoqueController extends AbstractActionController
{

    /**
     * Este método será executado sempre que a classe for instanciada,
     * depois do construtor.
     * Faz o carregamento das classes que serão usadas pelo controlador.
     *
     * @return void
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $sessionManager = new SessionManager();
        $sessionManager->start();
    }

    public function indexAction()
    {
        $sessionManager = $this->container->get(SessionManager::class);

        $viewModel = new ViewModel();
        $viewModel->mensagem = isset($sessionManager->getStorage()->mensagem) ? $sessionManager->getStorage()->mensagem : '';
        $sessionManager->getStorage()->mensagem = '';
        return $viewModel;
    }

    /* Efetua o login do estoquista */
    public function loginAction()
    {
        $sessionManager = $this->container->get(SessionManager::class);

        $cpf = (string) $this->request->getPost('cpf');
        $senha = (string) $this->request->getPost('senha');

        if ($cpf == null || $senha == null || ! is_numeric($cpf)) {
            $sessionManager->getStorage()->mensagem = 'Dados inválidos';
            return $this->redirect()->toRoute('estoque');
        }

        $authentication = new AuthenticationService();
        $zendDb = $this->container->get('DbAdapter');
        $adapter = new CredentialTreatmentAdapter($zendDb);
        $adapter->setTableName('administradores');
        $adapter->setIdentity($cpf);
        $adapter->setIdentityColumn('cpf');
        $adapter->setCredential($senha);
        $adapter->setCredentialColumn('senha');
        $authentication->setAdapter($adapter);

        $resultado = $authentication->getAdapter()->authenticate();
        if ($resultado->isValid()) {
            $sessionManager->getStorage()->estoquista = [];
            $sessionManager->getStorage()->estoquista['cpf'] = $resultado->getIdentity();
            return $this->redirect()->toRoute('estoque', [
                'action' => 'manter-produto'
            ]);
        }
        {
            $sessionManager->getStorage()->mensagem = 'Dados inválidos';
            return $this->redirect()->toRoute('estoque');
        }
    }

    /* Encerra a sessão do estoquista */
    public function logoutAction()
    {
        $sessionManager = $this->container->get(SessionManager::class);
        $sessionManager->destroy();

        $this->redirect()->toRoute('estoque');
    }

    /* Exibe o menu de operações de estoque */
    public function manterProdutoAction()
    {
        $sessionManager = $this->container->get(SessionManager::class);

        if (! isset($sessionManager->getStorage()->estoquista)) {
            return $this->redirect()->toRoute('estoque');
        }
        {
            $estoquista = $sessionManager->getStorage()->estoquista;
            $cpf = $estoquista['cpf'];
            $produtoTable = $this->container->get('ProdutoTable');
            $produtos = $produtoTable->getAll();
        }
        $viewModel = new ViewModel();
        $viewModel->mensagem = isset($sessionManager->getStorage()->mensagem) ? $sessionManager->getStorage()->mensagem : '';
        $sessionManager->getStorage()->mensagem = '';
        $viewModel->cpf = $cpf;
        $viewModel->itens = $produtos->toArray();
        return $viewModel;
    }

    // Retorna um produto de acordo com o id passado
    private function selecionarProduto()
    {
        $id = (int) $this->params('id');
        if (! isset($id)) {
            $this->redirect()->toRoute('estoque', [
                'action' => 'manter-produto'
            ]);
        }
        $table = $this->container->get('ProdutoTable');

        $produtoSelecionado = $table->getOne($id)->toArray();
        return $produtoSelecionado;
    }

    /* Exclusão do produto */
    public function excluirAction()
    {
        $sessionManager = $this->container->get(SessionManager::class);
        $id = (int) $this->params('id');
        if (! is_null($id)) {
            $table = $this->container->get('ItemTable');
            $where = [
                'produto_id' => $id
            ];
            $pedidos = $table->getAll($where)->toArray();
            if (empty($pedidos)) {
                $table = $this->container->get('ProdutoTable');
                $table->delete([
                    'id' => $id
                ]);
            } else {
                $sessionManager->getStorage()->mensagem = 'produto consta em pedido';
            }
        }
        return $this->redirect()->toRoute('estoque', [
            'action' => 'manter-produto'
        ]);
    }

    // Gravação de novo produto
    public function incluirProdutoAction()
    {
        $sessionManager = $this->container->get(SessionManager::class);
        $preco = (int) $this->request->getPost('preco');
        $quantidade = (int) $this->request->getPost('quantidade');
        $nome = (string) $this->request->getPost('nome');
        $imgb64 = (string) $this->request->getPost('imgb64');

        if (! isset($nome) || $nome == null) {
            $sessionManager->getStorage()->mensagem = 'nome inválido';
            return $this->redirect()->toRoute('estoque', [
                'action' => 'incluir'
            ]);
        }
        {
            $dados = array(
                'nome' => $nome,
                'quantidade' => $quantidade,
                'valor' => $preco
            );
            $table = $this->container->get('ProdutoTable');
            $novoProduto = new Produto();
            $novoProduto->exchangeArray($dados);
            $table->insert($novoProduto);

            $codigo = $table->getLastCodigo();
            file_put_contents(PUBLIC_DIR . '/img/produtos/' . $codigo . '.base64', $imgb64);
        }
        return $this->redirect()->toRoute('estoque', [
            'action' => 'manter-produto'
        ]);
    }

    public function alterarProdutoAction()
    {
        $sessionManager = $this->container->get(SessionManager::class);
        $viewModel = new ViewModel();
        $produtoSelecionado = $this->selecionarProduto();
        $viewModel->produtoSelecionado = $produtoSelecionado;
        $viewModel->mensagem = $sessionManager->getStorage()->mensagem;
        $viewModel->storage = $sessionManager->getStorage();
        unset($sessionManager->getStorage()->mensagem);
        return $viewModel;
    }

    public function alterarAction()
    {
        $sessionManager = $this->container->get(SessionManager::class);
        $preco = (int) $this->request->getPost('preco');
        $entrada = (int) $this->request->getPost('entrada');
        $baixa = (int) $this->request->getPost('baixa');
        $quantidade = (int) $this->request->getPost('quantidade');
        $nome = (string) $this->request->getPost('nome');
        $id = (int) $this->request->getPost('id');
        $imgb64 = (string)$this->request->getPost('imgb64');
        $funcao = (string)$this->request->getPost('funcao');        
        
        if (empty($id) || $id == null || $preco == null || $preco <= 0 || !is_numeric($preco)) {
            $sessionManager->getStorage()->mensagem = 'valor inválido';
            return $this->redirect()->toRoute('estoque', ['action' => 'alterar-produto','id' => $id]);
        }
        {
            $table = $this->container->get('ProdutoTable');
            $produto = $table->getOne($id)->toArray();

            if ($funcao == "entrada") {
                $quantidade = $quantidade + $entrada;
                $dados = array(
                    'quantidade' => $quantidade,
                );
                $produto = new Produto();
                $produto->exchangeArray($dados);
                $where = ['id' => $id];
                $table->update($produto, $where);
                return $this->redirect()->toRoute('estoque', ['action' => 'manter-produto']);
            }
            if($funcao == "baixa"){
                $quantidade = $quantidade - $baixa;
                
                $dados = array(
                    'quantidade' => $quantidade,
                );
                $produto = new Produto();
                $produto->exchangeArray($dados);
                $where = ['id' => $id];
                $table->update($produto, $where);
                return $this->redirect()->toRoute('estoque', ['action' => 'manter-produto']);
            }
        $dados = array(
            'valor' => $preco,
            'quantidade' => $quantidade,
            'nome' => $nome
        );
        $produto = new Produto();
        $produto->exchangeArray($dados);
        $where = ['id' => $id];

        file_put_contents(PUBLIC_DIR . '/img/produtos/' . $id . '.base64', $imgb64);
        $table->update($produto, $where);

        return $this->redirect()->toRoute('estoque', ['action' => 'manter-produto']);
        }
    }
}

```
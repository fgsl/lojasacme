###IndexController

* O indexController está interligado com todos os meios da interface de logar no site, se cadastrar, fazer logout e gravar o cliete dentro do site.

```

class IndexController extends AbstractActionController
{

    /**
     *
     * @var ServiceManager
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $sessionManager = new SessionManager();
        $sessionManager->start();
    }

    public function indexAction()
    {
        $sessionManager = $this->container->get(SessionManager::class);
        $sessionManager->getStorage()->ultimaPagina = __METHOD__;
        
        $chave = (string) $this->request->getPost('nome');
        $table = $this->container->get('ProdutoTable');
        $where = null;
        if (!empty($chave)){
            $where = new Where();
            $where->like('nome', "$chave%");
        }
        
        $viewModel = new ViewModel([
            'produtos' => $table->getAll($where)
        ]);
        
        $viewModel->storage = $sessionManager->getStorage();
        return $viewModel;
        
    }

    public function cadastrarAction()
    {
        $sessionManager = $this->container->get(SessionManager::class);
        $sessionManager->getStorage()->ultimaPagina = __METHOD__;
        
        $viewModel = new ViewModel([
            'mensagem' => (isset($sessionManager->getStorage()->mensagem) ? $sessionManager->getStorage()->mensagem : '')]);
        $sessionManager->getStorage()->mensagem = '';
        return $viewModel;
    }

    // Persistência dos dados do cliente
    public function gravarClienteAction()
    {
        $sessionManager = $this->container->get(SessionManager::class);
        $cpf = $this->request->getPost('cpf');
        $email = $this->request->getPost('email');
        $senha = $this->request->getPost('senha');
        $senha2 = $this->request->getPost('senha2');

        if ($senha != $senha2 || ! is_numeric($cpf) || $cpf == null || $email == null || $senha == null || $senha2 == null) {
            $sessionManager->getStorage()->mensagem = 'dados invalidos';
            return $this->redirect()->toRoute('application', [
                'action' => 'cadastrar'
            ]);
        }

        $usuarioTable = $this->container->get('UsuarioTable');
        $usuario = $usuarioTable->getAll([
            'cpf' => $cpf
        ])->toArray();
        $cpfExiste = ! empty($usuario);

        if ($cpfExiste) {
            $sessionManager->getStorage()->mensagem = 'CPF já cadastrado';
            return $this->redirect()->toRoute('application', [
                'action' => 'cadastrar'
            ]);
        }
        $usuario = $usuarioTable->getAll([
            'email' => $email
        ])->toArray();
        $emailExiste = ! empty($usuario);

        if ($emailExiste) {
            $sessionManager->getStorage()->mensagem = 'E-mail já cadastrado';
            return $this->redirect()->toRoute('application', [
                'action' => 'cadastrar'
            ]);
        }
        $usuario = new Usuario();
        $usuario->setCpf($cpf);
        $usuario->setEmail($email);
        $usuario->setSenha($senha);
        $usuarioTable->insert($usuario);
        return $this->redirect()->toRoute('application', [
            'action' => 'acessar'
        ]);
    }

    // Efetua o login do cliente
    public function loginAction()
    {
        $sessionManager = $this->container->get(SessionManager::class);
        $sessionManager->getStorage()->ultimaPagina = __METHOD__;
        $cpf = $this->request->getPost('cpf');
        $email = $this->request->getPost('email');
        $senha = $this->request->getPost('senha');

        if($cpf==null && $email==null){
            $sessionManager->getStorage()->mensagem = 'Dados inválidos';
            return $this->redirect()->toRoute('application', [ 'action' => 'acessar']);
        }
         
        $authentication = new AuthenticationService();
        $zendDb = $this->container->get('DbAdapter');
        $adapter = new CredentialTreatmentAdapter($zendDb);
        $adapter->setTableName('usuarios');
        $adapter->setIdentityColumn($cpf ? 'cpf' : 'email');
        $adapter->setCredentialColumn('senha');
        $adapter->setIdentity($cpf ? $cpf : $email);
        $adapter->setCredential($senha);
        $authentication->setAdapter($adapter);

        $resultado = $authentication->getAdapter()->authenticate();
        if ($resultado->isValid()) {
            $sessionManager->getStorage()->cliente = $resultado->getIdentity();
            return $this->redirect()->toRoute('carrinho');
        } {
            $sessionManager->getStorage()->mensagem = 'Dados inválidos';
            return $this->redirect()->toRoute('application', ['action' => 'acessar'
            ]);
        }
    }

    // Identificação do cliente
    public function acessarAction()
    {
        $sessionManager = $this->container->get(SessionManager::class);
        $sessionManager->getStorage()->ultimaPagina = __METHOD__;
        
        if (isset($sessionManager->getStorage()->cliente)) {
            return $this->redirect()->toRoute('carrinho');
        }
        $viewModel = new ViewModel();
        $viewModel->mensagem = isset($sessionManager->getStorage()->mensagem) ? $sessionManager->getStorage()->mensagem : '';
        unset($sessionManager->getStorage()->mensagem);
        return $viewModel;
    }

    // Encerra a sessão do cliente, destruindo o carrinho
    public function logoutAction()
    {
        $sessionManager = $this->container->get(SessionManager::class);             
                
        $ultimaPagina = $sessionManager->getStorage()->ultimaPagina;
        
        $tokens = explode('::',$ultimaPagina);
        //$action = str_replace('Action','',$tokens[1]);
        $action = str_replace('Action','',$tokens);
        $route = str_replace('index', 'home', lcfirst(str_replace('Controller', '', str_replace('Application\Controller\\','',$tokens[0])))); // nome da classe

        $sessionManager->destroy();
        $params = (empty($action)?[]:['action' => $action]);
        return $this->redirect()->toRoute($route, $params);
    }
}

```


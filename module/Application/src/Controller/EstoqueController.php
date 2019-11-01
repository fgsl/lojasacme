<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter;
use Zend\Authentication\Validator\Authentication;
use Zend\Session\SessionManager;
use Interop\Container\ContainerInterface;
use Application\Model\Item;
use Application\Model\ProdutoTable;
use Application\Model\Produto;
use Application\Model\ItemTable;

class EstoqueController extends AbstractActionController{
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

    public function defaultAction()
    {
        $sessionManager = $this->container->get(SessionManager::class);
        
        $viewModel = new ViewModel();
        $viewModel->mensagem = isset($sessionManager->getStorage()->mensagem) ? $sessionManager->getStorage()->mensagem : '';
        $sessionManager->getStorage()->mensagem = '';
        return $viewModel;
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
    
    $cpf = (string)$this->request->getPost('cpf');
    $senha = (string)$this->request->getPost('senha');
    
    if($cpf == null || $senha == null || !is_numeric($cpf)){
        $sessionManager->getStorage()->mensagem = 'Dados inválidos';
        return $this->redirect()->toRoute('estoque');
    }
    
    if ($cpf) {
        $where = [
            'cpf' => $cpf
        ];
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
        $sessionManager->getStorage()->estoquista ['cpf'] = $resultado->getIdentity();
        return $this->redirect()->toRoute('estoque',['action' => 'manter-produto']);
    } else {
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
    
    if (!isset($sessionManager->getStorage()->estoquista))
    { 
        return $this->redirect()->toRoute('estoque');}
    else
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
private function selecionarProduto(){
    $id = (int)$this->params('id');
    if (!isset($id))
    {
        $this->redirect()->toRoute('estoque',['action'=>'manter-produto']);
    }
    $table = $this->container->get('ProdutoTable');

    $produtoSelecionado = $table->getOne($id)->toArray();
    return $produtoSelecionado;
}

public function baixaAction()
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

public function entradaAction()
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

public function nomeAction()
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

public function precoAction()
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

/* Adição de quantidade de estoque */
public function adicionarAction()
{
    $sessionManager = $this->container->get(SessionManager::class);
    $id = (int)$this->request->getPost('id');
    if (!is_null($id))
    {
        $quantidade = (int)$this->request->getPost('quantidade');
        if($quantidade <= 0 || $quantidade == null)
        {
            $sessionManager->getStorage()->mensagem = 'valor inválido';
            return $this->redirect()->toRoute('estoque',['action' => 'entrada','id' => $id]);
        }
        $table = $this->container->get('ProdutoTable');
        $produto = $table->getOne($id)->toArray();
        $quantidade = $quantidade + $produto['quantidade'];
        $dados = array('quantidade' => $quantidade);
        $produto = new Produto();
        $produto->exchangeArray($dados);
        $where = ['id'=> $id];
        $table->update($produto, $where);
    }
    return $this->redirect()->toRoute('estoque',['action'=>'manter-produto']);
}

/* Subtração de quantidade de estoque */
public function subtrairAction()
{
    $sessionManager = $this->container->get(SessionManager::class);
    $id = (int)$this->request->getPost('id');
    if (!is_null($id))
    {
        $quantidade = (int)$this->request->getPost('quantidade');
        if($quantidade <= 0 || $quantidade == null)
        {
            $sessionManager->getStorage()->mensagem = 'valor inválido';
            return $this->redirect()->toRoute('estoque',['action' => 'baixa','id' => $id]);
        }
        $table = $this->container->get('ProdutoTable');
        $produto = $table->getOne($id)->toArray();
        $quantidade = $produto['quantidade'] - $quantidade;
        $dados = array('quantidade' => $quantidade);
        $produto = new Produto();
        $produto->exchangeArray($dados);
        $where = ['id'=> $id];
        $table->update($produto, $where);
    }
    return $this->redirect()->toRoute('estoque',['action'=>'manter-produto']);
}

/* Gravação de um novo preco */
public function alterarPrecoAction()
{
    $sessionManager = $this->container->get(SessionManager::class);
    $id = (int)$this->request->getPost('id');
    $preco = (string)$this->request->getPost('preco');

    if (is_null($id) || $preco == null || $preco <= 0 || !is_numeric($preco))
    {
        $sessionManager->getStorage()->mensagem = 'valor inválido';
        return $this->redirect()->toRoute('estoque',['action' => 'preco','id' => $id]);
    }
    else
    {
        $table = $this->container->get('ProdutoTable');
        $dados = array(
            'valor' => $preco
        );
        $produto = new Produto();
        $produto->exchangeArray($dados);
        $where = ['id' => $id];
        $table->update($produto, $where);
    }
return $this->redirect()->toRoute('estoque',['action'=>'manter-produto']);
}

/* Gravação de um novo nome */
public function alterarNomeAction()
{
     $sessionManager = $this->container->get(SessionManager::class);
     $id = (int)$this->request->getPost('id');
     $nome = (string)$this->request->getPost('nome');
     if (is_null($id) || $nome == null)
     {
         $sessionManager->getStorage()->mensagem = 'nome inválido';
         return $this->redirect()->toRoute('estoque',['action'=>'nome','id'=>$id]);
     }else{
         $table = $this->container->get('ProdutoTable');
         $dados = array('nome' => $nome);
         $produto = new Produto();
         $produto->exchangeArray($dados);
         $where = ['id' => $id];
         $table->update($produto, $where);
     }
     return $this->redirect()->toRoute('estoque',['action'=>'manter-produto']);
}

/* Exclusão do produto */
public function excluirAction()
{
    $sessionManager = $this->container->get(SessionManager::class);
    $id = (int)$this->params('id');
    if (!is_null($id))
    {
        $table = $this->container->get('ItemTable');
        $where = ['produto_id'=>$id];
        $pedidos = $table->getAll($where)->toArray();
        if (empty($pedidos))
        {
            $table = $this->container->get('ProdutoTable');
            $table->delete(['id' => $id]);
        }
        else
        {
            $sessionManager->getStorage()->mensagem = 'produto consta em pedido';
        }
    }
    return $this->redirect()->toRoute('estoque',['action'=>'manter-produto']);
} 

/* Inclusão de produto */
public function incluirAction()
{
    $sessionManager = $this->container->get(SessionManager::class);
    $viewModel = new ViewModel();
    $viewModel->mensagem = $sessionManager->getStorage()->mensagem;
    unset($sessionManager->getStorage()->mensagem);
    return $viewModel;
}

/* Gravação de novo produto */
public function incluirProdutoAction()
{
    $sessionManager = $this->container->get(SessionManager::class);
    $nome = (string)$this->request->getPost('nome');

    if (!isset($nome) || $nome == null)
    {    
    $sessionManager->getStorage()->mensagem = 'nome inválido';
    return $this->redirect()->toRoute('estoque',['action'=>'incluir']);
    }
    else{
        $dados = array(	
            'nome'=> $nome,
            'quantidade'=> 0,
            'valor' => 0            
        );        
        $table = $this->container->get('ProdutoTable');
        $novoProduto = new Produto();
        $novoProduto->exchangeArray($dados);
        $table->insert($novoProduto);
        
        $codigo = $table->getLastCodigo();
        file_put_contents(PUBLIC_DIR . '/img/produtos/' . $codigo . '.png', file_get_contents($_FILES['img']['tmp_name'] . '/'. $_FILES['img']['name']));
    }
    file_put_contents(PUBLIC_DIR . '/img/produtos/log.txt', print_r($_FILES,true));
    return $this->redirect()->toRoute('estoque',['action'=>'manter-produto']);
} 	

}
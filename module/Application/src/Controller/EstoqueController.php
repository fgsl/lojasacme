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
        $viewModel = new ViewModel();
        $viewModel->mensagem=isset($_SESSION['mensagem']) ? $_SESSION['mensagem'] : '';
        $_SESSION['mensagem'] = '';
        return $viewModel;
    }
    
 public function indexAction()
 {
     $viewModel = new ViewModel();
     $viewModel->mensagem=isset($_SESSION['mensagem']) ? $_SESSION['mensagem'] : '';
     $_SESSION['mensagem'] = '';
     return $viewModel;
 }

/* Efetua o login do estoquista */
public function loginAction()
{
    $cpf = (string)$this->request->getPost('cpf');
    $senha = (string)$this->request->getPost('senha');
    
    if($cpf == null && $senha == null){
        $_SESSION['mensagem'] = 'Dados inválidos';
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
        $_SESSION['estoquista'] = [];
        $_SESSION['estoquista'] ['cpf'] = $resultado->getIdentity();
        return $this->redirect()->toRoute('estoque',['action' => 'manter-produto']);
    } else {
        $_SESSION['mensagem'] = 'Dados inválidos';
        return $this->redirect()->toRoute('estoque');
    }
}

/* Encerra a sessão do estoquista */
public function logoutAction()
{
    /* Mata todas as variáveis de sessão */
    $_SESSION = array();
    /* Apaga o cookie de sessão */
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-42000,'/');
    }
    session_destroy();
    $this->redirect()->toRoute('estoque');
}

/* Exibe o menu de operações de estoque */
public function manterProdutoAction()
{
    if (!isset($_SESSION['estoquista']))
    { 
        return $this->redirect()->toRoute('estoque');}
    else
    {
        $estoquista = $_SESSION['estoquista'];
        $cpf = $estoquista['cpf'];
        $produtoTable = $this->container->get('ProdutoTable');
        $produtos = $produtoTable->getAll();
    }
    $viewModel = new ViewModel();
    $viewModel->mensagem = isset($_SESSION['mensagem']) ? $_SESSION['mensagem'] : '';
    $_SESSION['mensagem'] = '';
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
    /* return $produtoSelecionado[0]; */
}

public function baixaAction()
{
    $viewModel = new ViewModel();
    $produtoSelecionado = $this->selecionarProduto();
    $viewModel->produtoSelecionado = $produtoSelecionado;
    $viewModel->mensagem = $_SESSION ['mensagem'];
    unset($_SESSION ['mensagem']);
    return $viewModel;
}

public function entradaAction()
{
    $viewModel = new ViewModel();
    $produtoSelecionado = $this->selecionarProduto();
    $viewModel->produtoSelecionado = $produtoSelecionado;
    $viewModel->mensagem = $_SESSION ['mensagem'];
    unset($_SESSION ['mensagem']);
    return $viewModel;
}

public function nomeAction()
{
    $viewModel = new ViewModel();
    $produtoSelecionado = $this->selecionarProduto();
    $viewModel->produtoSelecionado = $produtoSelecionado;
    $viewModel->mensagem = $_SESSION ['mensagem'];
    unset($_SESSION ['mensagem']);
    return $viewModel;
}

public function precoAction()
{
    $viewModel = new ViewModel();
    $produtoSelecionado = $this->selecionarProduto();
    $viewModel->produtoSelecionado = $produtoSelecionado;
    return $viewModel;
}

/* Adição de quantidade de estoque */
public function adicionarAction()
{
    $id = (int)$this->request->getPost('id');
    if (!is_null($id))
    {
        $quantidade = (int)$this->request->getPost('quantidade');
        if($quantidade <= 0 || $quantidade == null)
        {
            $_SESSION['mensagem'] = 'valor inválido';
            return $this->redirect()->toRoute('estoque',['action' => 'baixa','id' => $id]);
        }
        $table = $this->container->get('ProdutoTable');
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
    $id = (int)$this->request->getPost('id');
    if (!is_null($id))
    {
        $quantidade = (int)$this->request->getPost('quantidade');
        if($quantidade <= 0 || $quantidade == null)
        {
            $_SESSION['mensagem'] = 'valor inválido';
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
    $id = (int)$this->request->getPost('id');
    $preco = (string)$this->request->getPost('preco');

    if (is_null($id) || $preco == null || $preco <= 0)
    {
        $_SESSION['mensagem'] = 'valor inválido';
        return $this->redirect()->toRoute('estoque',['action' => 'baixa','id' => $id]);
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
     $id = (int)$this->request->getPost('id');
     $nome = (string)$this->request->getPost('nome');
     if (is_null($id) || $nome == null)
     {
         $_SESSION['mensagem'] = 'nome inválido';
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
            $_SESSION['mensagem'] = 'produto consta em pedido';
        }
    }
    return $this->redirect()->toRoute('estoque',['action'=>'manter-produto']);
}

/* Inclusão de produto */
public function incluirAction()
{
    $viewModel = new ViewModel();
    $viewModel->mensagem = $_SESSION ['mensagem'];
    unset($_SESSION ['mensagem']);
    return $viewModel;
}

/* Gravação de novo produto */
public function incluirProdutoAction()
{
    $nome = (string)$this->request->getPost('nome');

    if (!isset($nome) || $nome == null)
    {    
    $_SESSION['mensagem'] = 'nome inválido';
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
    }
    return $this->redirect()->toRoute('estoque',['action'=>'manter-produto']);
} 	

}
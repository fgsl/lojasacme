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
        $_SESSION['estoquista'] = $resultado->getIdentity();
        return $this->redirect()->toRoute('estoque',['action' => 'manter-produto']);
    } else {
        $_SESSION['mensagem'] = 'Dados inválidos';
        return $this->redirect()->toRoute('estoque');
    }
}

/* Exibe o menu de operações de estoque */
public function manterProduto()
{
    if (!isset($_SESSION['estoquista']))
    { 
        $this->redirect()->toRoute('estoque');}
    else
    {
        $estoquista = $_SESSION['estoquista'];
        $cpf = $estoquista['cpf'];
        $itemTable = $this->container->get('itemTable');
        $itens = $itemTable->getAll();
    }
    $viewModel = new ViewModel();
    $viewModel->mensagem = isset($_SESSION['mensagem']) ? $_SESSION['mensagem'] : '';
    $_SESSION['mensagem'] = '';
    $viewModel->assign('cpf',$cpf);
    $viewModel->assign('itens',$itens->toArray());
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

// Retorna um produto de acordo com o id passado
private function selecionarProduto(){
    $id = (int)$this->params()->fromRoute('id');
    if (!isset($id))
    {
        $this->redirect()->toRoute('estoque',['action'=>'manter-produto']);
        exit;
    }
    $table = $this->container->get('ProdutoTable');
    $produtoSelecionado = $table->getOne($id)->toArray();
//  $produtoSelecionado = $table->find($id)->toArray();
    return $produtoSelecionado[0];
}

public function entradaAction()
{
    $viewModel = new ViewModel();
    $produtoSelecionado = $this->selecionarProduto();
    $viewModel->produtoSelecionado = $produtoSelecionado;
    $viewModel->setTemplate('application/estoque/default.phtml');
     return $viewModel;
}

public function baixaAction()
{
    $viewModel = new ViewModel();
    $produtoSelecionado = $this->selecionarProduto();
    $viewModel->produtoSelecionado = $produtoSelecionado;
    $viewModel->setTemplate('application/estoque/default.phtml');
    return $viewModel;
}

public function nomeAction()
{
    $viewModel = new ViewModel();
    $produtoSelecionado = $this->selecionarProduto();
    $viewModel->produtoSelecionado = $produtoSelecionado;
    $viewModel->setTemplate('application/estoque/default.phtml');
    return $viewModel;
}

public function precoAction()
{
    $viewModel = new ViewModel();
    $produtoSelecionado = $this->selecionarProduto();
    $viewModel->produtoSelecionado = $produtoSelecionado;
    $viewModel->setTemplate('application/estoque/default.phtml');
    return $viewModel;
}
}
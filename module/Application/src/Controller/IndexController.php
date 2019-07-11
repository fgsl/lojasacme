<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\ViewModel;
use Application\Model\Usuario;
use Zend\Session\SessionManager;

class IndexController extends AbstractActionController
{

    /**
     *
     * @var ServiceManager
     */
    protected $sm;

    public function __construct(ServiceManager $sm)
    {
        $this->sm = $sm;
        $sessionManager = new SessionManager();
        $sessionManager->start();
    }

    public function indexAction()
    {
        return new ViewModel([
            'produtos' => $this->sm->get('ProdutoTable')->getAll()
        ]);
    }

    public function buscarAction()
    {
        return new ViewModel();
    }

    /* Identificação do cliente */
    public function acessarAction()
    {
        if (isset($_SESSION['cliente']))
        {
            $this->redirect()->toRoute('/carrinho/comprar');
        }
        $viewModel = new ViewModel();
        $viewModel->mensagem = isset($_SESSION['mensagem']) ? $_SESSION['mensagem'] : '';
        return $viewModel;
    }

    public function cadastrarAction()
    {
        $viewModel = new ViewModel([
            'mensagem' => (isset($_SESSION['mensagem']) ? $_SESSION['mensagem'] : '')            
        ]);
        $_SESSION['mensagem'] = '';
        return $viewModel;
    }

    /* Persistência dos dados do cliente */
    public function gravarClienteAction()
    {
        $cpf = $this->request->getPost('cpf');	 
        $email = $this->request->getPost('email');
        $senha = $this->request->getPost('senha');
	    $senha2 = $this->request->getPost('senha2');
    
        if ($senha != $senha2) {
            $_SESSION['mensagem'] = 'Dados inválidos';
            return $this->redirect()->toRoute('application',['action' => 'cadastrar']);
        }
        $usuarioTable = $this->sm->get('UsuarioTable');
        $usuario = $usuarioTable->getAll(['cpf' => $cpf])->toArray();
        $cpfExiste = ! empty($usuario);

        if ($cpfExiste) {
            $_SESSION['mensagem'] = 'CPF já cadastrado';
            return $this->redirect()->toRoute('application',['action' => 'cadastrar']);
        }
        $usuario = $usuarioTable->getAll(['email' => $email])->toArray();
        $emailExiste = ! empty($usuario);
        
        if ($emailExiste) {
            $_SESSION['mensagem'] = 'E-mail já cadastrado';
            return $this->redirect()->toRoute('application',['action' => 'cadastrar']);
       }
        $usuario = new Usuario();
        $usuario->setCpf($cpf);
        $usuario->setEmail($email);
        $usuario->setSenha($senha);
        $usuarioTable->insert($usuario);
        return $this->redirect()->toRoute('application',['action' => 'acessar']);
    }

    /* Efetua o login do cliente */
    public function loginAction()
    {
        $cpf = $this->params()->fromRoute('cpf');
        $email = $this->params()->fromRoute('email');
        $senha = $this->params()->fromRoute('senha');
        
        if ($cpf)
        {
            $campo = 'cpf';
        }   
        else
        {
            $campo = 'email';
        }

        $where = $table->getAdapter()->quoteInto("$campo = ?", $cpf);
        $usuario = $table->fetchAll($where)->toArray();
        
        if (!empty($usuario) &&
            $usuario[0]['senha'] == $senha)
        {
            $_SESSION['cliente'] = $usuario;
            $this->redirect()->toRoute('/carrinho');
        }
        else
        {
            $_SESSION['mensagem'] = 'Dados inválidos';
            $this->redirect()->toRoute('/index/acessar');
    $_SESSION['mensagem'] = '';
        }      
    }

    /* Grava o pedido de compra */
    public function gravarCompra()
    {
        $formaEscolhida = $this->params()('formaPagamento');
        $formasPagamento = array('boleto'=>'Boleto
Bancário','cartao'=>'Cartão de Crédito');
        $codigo = mt_rand(10000,99999);
        $pedidoTable = $this->sm->get('PedidoTable');
        $idPedido = $pedidoTable->insert(array('codigo'=>$codigo));
        $itens = $_SESSION['carrinho'];
        foreach ($itens as $item)
        {
            $dados = array('pedido_id'=>$idPedido,
                'produto_id'=>$item['id'],
                'valor'=>$item['valor'],
                'quantidade'=>$item['quantidade']);
            $novoItem = $this->sm->get('ItemTable');
            $novoItem->insert($dados);
        }
        unset($_SESSION['carrinho']);
        $mensagem = "O pedido $codigo pago com {$formasPagamento[$formaEscolhida]} foi finalizado com sucesso";
        $viewModel->mensagem=$mensagem;
    }
            
    /* Encerra a sessão do cliente, destruindo o 	carrinho */
    public function logoutAction()
    {
        /* Mata todas as variáveis de sessão */
        $_SESSION = array();
        /* Apaga o cookie de sessão */
        if (isset($_COOKIE[session_name()])) {setcookie(session_name(), '', time()-42000, '/');
        }
        /* Destrói a sessão. */
        session_destroy();
        $this->redirect()->toRoute('/');
    }
}
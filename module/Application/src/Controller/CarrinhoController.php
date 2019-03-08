<?php

use Zend\Mvc\Controller\AbstractActionController;
use Application\Model\Produto;
use Zend\View\Model\ViewModel;

class CarrinhoController extends AbstractActionController
{
    /**
     * Este método será executado sempre que a classe for
     instanciada,
     * depois do construtor.
     * Faz o carregamento das classes que serão usadas pelo
     controlador.
     *
     * @return void
     */
        
        /* Página do carrinho de compras */
        public function comprarAction()
        {
            $mensagem = '';
            if (!isset($_SESSION['carrinho']))
            {
                $_SESSION['carrinho'] = array();
            }
            $carrinho = $_SESSION['carrinho'];
            if (!is_null($this->params()('id')))
            {
                $id = (int)$this->params()('id');
                $incluido = FALSE;
                foreach ($carrinho as $produto)
                {
                    if (isset($produto['id']))
                    {
                        if ($produto['id'] == $id )
                        {
                            $incluido = TRUE;
                            $mensagem = 'Produto já selecionado';
                            break;
                        }
                    }
                }
                If (!$incluindo)
                {
                    $produtos = new Produto();
                    $item = $produtos-> getOne($id)->toArray();
                    $item[0][‘quantidade’]=1;
                    $carrinho[] = $item[0];
                    $_SESSION[‘carrinho’] = $carrinho;
                }
            }
            $viewModel = $viewModel = new ViewModel();
            
            $viewModel->mensagem = $mensagem;
            $viewModel-> assign(‘itens’,$carrinho);
            
            
            $viewModel->assign(‘body’,’comprar.phtml’);
            $this->_response→setBody($viewModel->render(‘default.phtml’));
        
        
        }
        public function indexAction()
        {
            $this->redirect('/carrinho/comprar');
        }
        
        public function excluirAction()
        {
            $id = (int)$this->_request->getParam('id');
            if (is_null($id))
            {
                $this->_redirect('/carrinho/');
                exit;
            }
            foreach ($_SESSION['carrinho'] as $chave => $produto)
            {
                if ($produto['id'] == $id )
                {
                    unset($_SESSION['carrinho'][$chave]);
                    break;
                }
            }
            $this->_redirect('/carrinho/');
        }
        $viewModel = new ViewModel();
        $viewModel->assign('produtoSelecionado' $produtoSelecionado);
        
        $viewModel->assign('body','editar.phtml');
        $thisModel->_response->setBody($viewModel->render('default.phtml'));
      
        
      public function alterarAction()
        {
             Alteração de quantidade de um item do carrinho
            $id = (int)$this→_request→getParam('id');
            
            if (is_null($id))
            {
                $this->_redirect('/carrinho/');
                exit;
            }
          $quantidade = (int) $this->_request->getParam('quantidade');
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
 			$this→_redirect('/carrinho/');
     
        
       Fechamento da compra 
 		public function fecharAction()
 		{
 			if (!isset($_SESSION['cliente']))
 			{
 				$this->_redirect('/index/acessar');
 				exit;
 			}
}

$viewModel = new ViewModel();
$viewModel->assign('body','fechar.phtml');
$this->_response->setBody($view->render('default.phtml'));
} 
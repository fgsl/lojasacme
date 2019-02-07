<?php

use Zend\Mvc\Controller\AbstractActionController;

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
                    $item = $produtos-> find($id)->toArray();
                    $item[0][‘quantidade’]=1;
                    $carrinho[] = $item[0];
                    $_SESSION[‘carrinho’] = $carrinho;
                }
            }
            $viewModel = $viewModel = new ViewModel();
            
            $viewModel->mensagem =  $mensagem;
            $viewModel-> assign(‘itens’,$carrinho);
            
            
            $viewModel→assign(‘body’,’comprar.phtml’);
            $this->_response→setBody($viewModel->render(‘default.phtml’));
        } 
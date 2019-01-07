<?php

class CarrinhoController extends Zend_Controller_Action
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
    public function init()
    {
        Zend_Loader::loadClass('Usuarios');
        Zend_Loader::loadClass('Produtos');
        Zend_Loader::loadClass('Itens');
        Zend_Loader::loadClass('Pedidos');
        
        /* Página do carrinho de compras */
        public function comprarAction()
        {
            $mensagem = '';
            if (!isset($_SESSION['carrinho']))
            {
                $_SESSION['carrinho'] = array();
            }
            $carrinho = $_SESSION['carrinho'];
            if (!is_null($this->_request->getParam('id')))
            {
                $id = (int)$this->_request->getParam('id');
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
                    $produtos = new Produtos();
                    $item = $produtos→ find($id)→toArray();
                    $item[0][‘quantidade’]=1;
                    $carrinho[] = $item[0];
                    $_SESSION[‘carrinho’] = $carrinho;
                }
            }
            $view = Zend_Registry:: get (‘view’);
            
            $view→ assign(‘mensagem’,$mensagem);
            $view→ assign(‘itens’,$carrinho);
            
            $view→assign(‘header’,’pageHeader.phtml’);
            $view→assign(‘body’,’comprar.phtml’);
            $view→assign(‘footer’,‘PageFooter.phtml’);
            $this→_response→setBody($view→render(‘default.phtml’));
        } 
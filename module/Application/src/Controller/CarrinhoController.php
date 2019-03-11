<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Model\Produto;
use Zend\View\Model\ViewModel;

class CarrinhoController extends AbstractActionController
{

    /* Página do carrinho de compras */
    public function comprarAction()
    {
        $mensagem = '';
        if (! isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = array();
        }
        $carrinho = $_SESSION['carrinho'];
        if (! is_null($this->_request->getParam('id'))) {
            $id = (int) $this->_request->getParam('id');
            $incluido = FALSE;
            foreach ($carrinho as $produto) {
                if (isset($produto['id'])) {
                    if ($produto['id'] == $id) {
                        $incluido = TRUE;
                        $mensagem = 'Produto já selecionado';
                        break;
                    }
                }
            }
            If (! $incluido) {
                $produtos = new Produto();
                $item = $produtos->find($id)->toArray();
                $item[0][‘quantidade’] = 1;
                $carrinho[] = $item[0];
                $_SESSION[‘carrinho’] = $carrinho;
            }
        }
        $viewModel = new ViewModel();

        $viewModel->mensagem = $mensagem;
        $viewModel->assign(‘itens’, $carrinho);

        $viewModel->assign(‘body’, ’comprar . phtml’);
        $this->response->setBody($viewModel->render(‘default . phtml’));
    }
}
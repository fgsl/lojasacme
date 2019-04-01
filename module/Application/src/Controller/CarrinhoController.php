<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Model\Produto;
use Zend\View\Model\ViewModel;
use Zend\Http\Header\Range;

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
        if (! is_null($this->params('id'))) {
            $id = (int) $this->params('id');
            $incluindo = FALSE;
            foreach ($carrinho as $produto) {
                if (isset($produto['id'])) {
                    if ($produto['id'] == $id) {
                        $incluindo = TRUE;
                        $mensagem = 'Produto já selecionado';
                        break;
                    }
                }

                If (! $incluindo) {
                    $produtos = new Produto();
                    $item = $produtos->getOne($id)->toArray();
                    $item[0]['quantidade'] = 1;
                    $carrinho[] = $item[0];
                    $_SESSION['carrinho'] = $carrinho;
                }
            }
        }
        $viewModel = $viewModel = new ViewModel();
        
        $viewModel->mensagem = $mensagem;
        $viewModel->itens =  $carrinho;
        return $viewModel;        
    }

    public function indexAction()
    {
           return $this->redirect('carrinho');
    }

    public function excluirAction()
    {
        $id = (int) $this->params('id');
        if (is_null($id)) {
            return $this->redirect('carrinho');
        }
        foreach ($_SESSION['carrinho'] as $chave => $produto) {
            if ($produto['id'] == $id) {
                unset($_SESSION['carrinho'][$chave]);
                break;
            }
        }
        return $this->redirect('carrinho');
    }
}
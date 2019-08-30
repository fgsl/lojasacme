<?php
/**
 * Este método será executado sempre que a classe
 for instanciada,
 * depois do construtor.
 * Faz o carregamento das classes que serão
 usadas pelo controlador.
 *
 * @return void
 */
/**
 * Método que mostra o resultado da pesquisa
 *
 * @return void
 */

public function indexAction()
{
    $chave = (string)$this->_request->getParam('nome');
    $viewModel = Zend_Registry::get('view');
    $table = new Produtos();
    $where = "position('$chave' in nome)>0";
    $produto = $table->fetchAll($where);
    
    $viewModel->assign('produtos',$produtos->toArray());
}
}
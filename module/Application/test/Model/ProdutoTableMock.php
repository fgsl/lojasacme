<?php

/**
 * Modelo da classe ProdutoTable
 * @filesource
 * @author Felipe Godoi
 * @copyright Copyright 2012 SERPRO
 * @package Application
 * @subpackage Model
 * @version 1.0
 */
namespace ApplicationTest\Model;

use Application\Model\Produto;
use Application\Model\ProdutoTable;

class ProdutoTableMock extends ProdutoTable
{   
    public function getOne($id)
    {
        $model = new Produto();
        $model->exchangeArray(['id'=>1,'nome'=>'caixa preta','valor'=>1,'quantidade'=>1]);
        return $model;
    }
}

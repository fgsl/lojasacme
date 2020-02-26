###Pedido

<blockquote>
  <p>
  Aqui não tem tanta coisa para falar, principalmente por que ele está referente sobre algumas cosias ja faladas.
  </p>
  <p>Ele puxa algumas informações do sistem. Vou explicar melhor no PedidoTable onde lá que ele pega os sistemas principais</p>
</blockquote>

```

<?php
/**
 * Modelo da classe Pedido
 * @filesource
 * @author Felipe Godoi
 * @copyright Copyright 2012 SERPRO
 * @package Application
 * @subpackage Model
 * @version 1.0
 */
namespace Application\Model;

class Pedido
{
    public $id;
    public $codigo;

    // setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    // getters
    public function getId()
    {
        return $this->id;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
} 

```


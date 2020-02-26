###Itens.phtml

O itens.phtml é algo bem simples de se compreender, onde fala sobre principalmente sobre a soma total de nome quantidade e o tipo de dinheiro que é usado na hora da transação e também é representado o valor total no final da conta.

* A interpretação do codigo está referente em principalmente sobre a soma do valor de todos os itens.

```

<?php

global $somaTotal;
?>
<?=$this->id?>
<?=$this->escapeHtml($this->nome)?>
<?=$this->escapeHtml($this->quantidade)?>
<?=$this->escapeHtml(money_format('%.2n',$this->valor))?>
<?php
$valorTotal  =  $this->quantidade * $this->valor;
$somaTotal += $valorTotal;
?>
<?=$this->escapeHtml(money_format('%.2n',$valorTotal))?>

```

###Fechar

* Fala principalmente sobre gravar as formas de pagamentos, por exemplo, cartão de credito.

```

<div class="container">
<form action="<?=$this->url('carrinho',['action'=>'gravar-compra'])?>" method="post">
<h2>Forma de pagamento:</h2>
<?=$this->escapeHtml('Boleto Bancário')?>
<input name="formaPagamento" value="boleto" id="formaPagamento" type="radio"/>
<?=$this->escapeHtml('Cartão de Crédito')?>
<input name="formaPagamento" value="cartao" id="formaPagamento" type="radio"/>
<input type="submit" name="gravar" value="Gravar"/>
</form>
<br>
<a href="<?=$this->url('carrinho')?>" class="btn-floating btn-lg btn-default"><i class="glyphicon glyphicon-shopping-cart"></i></a>
</div>



```


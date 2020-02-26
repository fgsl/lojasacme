###Editar

* As edições principalmente na hora que você ver o carrinho, onde pode ser editado a quantidade dos intens colocados no carrinho.

```

<?php
if(trim($this->mensagem) !==""){
?>
<br>
<div class="row">
<div class="col-lg-1"></div>
    <div class="col-lg-10 alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    	<h3 id="danger"><?=$this->mensagem?></h3>
    </div>
</div>
<?php
}
?>
<div class="container">
<form class="form-horizontal" action="<?= $this->url('carrinho',['action'=>'alterar']) ?>" method="post">
<h2>alterar quantia:</h2>

<?php
if (isset($this->produtoSelecionado['id']))
{
echo '<b>Produto: '.$this->produtoSelecionado['nome'].'</b><br/>';
echo '<b>Preço: '.$this->produtoSelecionado['valor'].'</b><br/>';

?>

<div class="form-group">
<label class="control-label col-sm-1" for="quantidade">quantidade:</label>
<div class="col-sm-5">
<input type="text" class="form-control" id="quantidade" name="quantidade">
<input name="id" value="<?=$this->produtoSelecionado['id']?>" id="id"type="hidden"/>

<?php
}
?>
<input type="submit" name="alterar" value="Alterar"/>
</div>
</div>
</form><br>
<a href="<?=$this->url('carrinho')?>" class="btn-floating btn-lg btn-default"><i class="glyphicon glyphicon-shopping-cart"></i></a>
</div>

```
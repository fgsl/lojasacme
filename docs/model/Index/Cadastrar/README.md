###Cadastrar

No cadastrar.phtml está relatando como podemos fazer para se cadastrar dentro do site onde mostra algumas linhas sobre seu e-mail, CPF e sua senha para finalizar, está pedindo para colocar sua senha pela segunda vez.

* Ao o uso de alguns butões ou ate mesmo uso de linhas que pode ser usado também com o uso de css que pode facilitar o manuseamento dentro do site.

* O css pode ser usado para varias coisas, principalmente para fazer a interface do site que é o layout.

```

<?php
if($this->mensagem !==""){
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
  <h2>cadastrar conta:</h2>
  <form class="form-horizontal" action="<?=$this->url('application',['action'=>'gravar-cliente'])?>" method="post">
    <div class="form-group">
      <label class="control-label col-sm-2" for="cpf">cpf:</label>
      <div class="col-sm-5">
        <input type="text" class="form-control" id="cpf" name="cpf">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Email:</label>
      <div class="col-sm-5">
        <input type="email" class="form-control" id="email" name="email">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="senha">senha:</label>
      <div class="col-sm-5">          
        <input type="password" class="form-control" id="senha" name="senha">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="senha">senha:</label>
      <div class="col-sm-5">          
        <input type="password" class="form-control" id="senha2" name="senha2">
      </div>
    </div>
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default" name="cadastrar" value="cadastrar">cadastrar</button>
      </div>
    </div>    
  </form>
<a href="<?=$this->url('home')?>" class="btn-floating btn-lg btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>  
<a href="<?=$this->url('carrinho')?>" class="btn-floating btn-lg btn-default"><i class="glyphicon glyphicon-shopping-cart"></i></a>
</div>

```
###Acessar

Os comandos de acessar.phtml foi necesariamente programado para servir como o login da Lojasacme onde ele proporcionar o desenvolvimento de colocar sua conta que é seu e-mail ou CPF e senha para se logar no site.

* Aqui também pode ser usado o css principalmente para a interface ao acessar o site e ao se cadastrar nele.

```

<html lang="en">
    <head><title>acessar</title></head>
        <meta charset="UTF-8">
        
<body>
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
<div class="container" id="conteudo">
  <h2>acessar conta:</h2>
  <form class="form-horizontal" action="<?=$this->url('application',['action'=>'login'])?>" method="post">
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
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default" name="login" value="Login">acessar</button>
      </div>
    </div>
  </form>
<a href="<?=$this->url('home')?>" class="btn-floating btn-lg btn-default"><i class="glyphicon glyphicon-share-alt"></i></a>  
<a href="<?=$this->url('carrinho')?>" class="btn-floating btn-lg btn-default"><i class="glyphicon glyphicon-shopping-cart"></i></a>
</div>
<br>
</body>
</html>

```
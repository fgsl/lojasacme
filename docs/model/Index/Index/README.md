###Index.phtml

Os comandos relacionados sobre o index.phtml está relacionado principalmente sobre a criação dos comandos para os botões, scrolls e as ações de alguns butões do site. Onde explica sobre todas essas coisas estão em referências uteis.

* Este está continuamente usando mais o "navbar" que é referente sobre o uso correto de botões em um site.

```

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="<?=$this->url('home')?>">Lojas Acme</a>
    </div>
    <form class="navbar-form navbar-right" action="<?=$this->url('application')?>" method="post">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="" name="nome" id="nome">
        <div class="input-group-btn">
          <button class="btn btn-default" type="submit">
            <i class="glyphicon glyphicon-search"></i>
          </button>
        </div>
      </div>
    </form>
    <?php
        if (!isset($this->storage->cliente))
        {
        ?>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="<?= $this->url('application',['action' => 'acessar']) ?>" >Acessar</a></li>
      <li><a href="<?= $this->url('application',['action' => 'cadastrar']) ?>" >Cadastrar</a></li>
    </ul>
    <?php
        }
        else
        {
    ?>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="<?= $this->url('application', ['action' => 'logout']) ?>" >Sair</a></li>
    </ul>
    <?php
        }
    ?>    
  </div>
</nav>

<form action="<?=$this->url('application')?>" method="post">
	<div class="jumbotron container" style="margin: auto;">
		<?=$this->partialLoop('produtos.phtml',$this->produtos)?>
	</div><br>
</form><br>

<div class="container">
<a onclick="topFunction()" id="myBtn" title="voltar ao topo" class="btn-floating btn-lg btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
</div>

<script>
var mybutton = document.getElementById("myBtn");

window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}
</script>

<!-- 
ir pro carrinho sem comprar nenhum produto
<a id="botao_comprar" href="<?=$this->url('carrinho',['action'=>'comprar'])?>">Comprar</a>
-->

```
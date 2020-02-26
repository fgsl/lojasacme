###Detalhes.phtml

* Aqui está detalhando principalmente em como acessar os lugares e se cadastrar. A compra tembém está relacionado, pois está aqui os detalhes da compra.

```

<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="<?=$this->url('home')?>">Lojas Acme</a>
		</div>
		<form class="navbar-form navbar-right"
			action="<?=$this->url('application')?>" method="post">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="" name="nome"
					id="nome">
				<div class="input-group-btn">
					<button class="btn btn-default" type="submit">
						<i class="glyphicon glyphicon-search"></i>
					</button>
				</div>
			</div>
		</form>
    <?php
    if (! isset($this->storage->cliente)) {
        ?>
    <ul class="nav navbar-nav navbar-right">
			<li><a
				href="<?= $this->url('application',['action' => 'acessar']) ?>">Acessar</a></li>
			<li><a
				href="<?= $this->url('application',['action' => 'cadastrar']) ?>">Cadastrar</a></li>
		</ul>
    <?php
    } else {
        ?>
    <ul class="nav navbar-nav navbar-right">
			<li><a
				href="<?= $this->url('application', ['action' => 'logout']) ?>">Sair</a></li>
		</ul>
    <?php
    }
    ?>    
  </div>
</nav>

<div class="container-fluid">
	<div class="row conteudo" style="height: 100%;">
		<div class="col-lg-offset-1 col-lg-7">
			<?php $img = file_get_contents(__DIR__ . '/../../../../../public/img/produtos/' . $this->item[id] . ".base64");?>
        	<img id="imgb" src="<?= $img ?>" class="img-responsive"
				alt="imagem indisponivel">
		</div>
		<div class="col-lg-3">
			<div class="row">
				<h2>
					<b>Produto: <?= $this->item[nome]?></b>
				</h2>
				<hr>
				<h2>
					<b>Preço: <?= $this->item[valor]?></b>
				</h2>
				<hr>
				<h3>
					<b>Posição de estoque: <?= $this->item[valor]?></b>
				</h3>
				<a
					href="<?=$this->url('carrinho',['action'=>'comprar','id'=>$this->item[id]])?>"
					class="btn btn-default">Comprar</a>
				<hr>
				<div class="row">
				<?php
    for ($i = 0; $i < 6; $i ++) {
        if ($this->produtos[$i][id] !== null) {

            $img = file_get_contents(__DIR__ . '/../../../../../public/img/produtos/' . $this->produtos[$i][id] . ".base64");
            ?>
				<div class="col-lg-4">
						<a href="<?= $this->url('carrinho',['action'=>'detalhes','id'=> $this->produtos[$i][id]])?>">
						<img id="imgMini" src="<?= $img ?>" class="img-responsive"  data-toggle="tooltip" data-placement="auto" title="<?=$this->produtos[$i][nome]?>" alt="imagem indisponivel"></a>
					</div>
				<?php }}?>
				</div>
			</div>
		</div>
		</form>
	</div>
	<a href="<?=$this->url('application')?>"
		class="btn-floating btn-lg btn-default"
		style="bottom: 70px; position: absolute;"><i
		class="glyphicon glyphicon-share-alt"></i></a>
</div>

```


<?php
<2 id="warning"><?=$this->mensagem?></h2>
<center>
<form action="/zend/acme/estoque/login"
method="post">
CPF:
<input name="cpf" value="" id="cpf" type="text">
senha:
<input name="senha" value="" id="senha"
type="password">
<input type="submit" name="login" value="Login"/>
</form>
</center>
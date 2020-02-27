<h1>3º Passo</h1>

O segundo passo está referente como podemos acessar o site com alguns comandos dentro do terminal.

Para iniciar a aplicação, use o servidor embutido do PHP. No diretório lojasacme, digite:

<h4>php -S localhost:8000 -t public/</h4>

Neste momento, a aplicação não funcionará porque faltam as dependências.
Pare o servidor (CTRL+C) e execute o composer no diretório lojasacme:

<h4>composer install</h4>
###2ºPasso

<h1>lojasacme</h1>
Exemplo de loja virtual

# Configuração do banco de dados

Criar arquivo local.php em config/autoload. 

Para usar um banco MySQL, o conteúdo do arquivo deve ser este:

```php
<?php
return [
	'db' => [
    	'driver' => 'PDO',
		'dsn' => 'mysql:host=localhost;port=5432;dbname=acme',
		'username' => '[USUÁRIO DO BANCO]',
		'password' => '[SENHA DO USUÁRIO DO BANCO]'
	],
]
```

O script para geração das tabelas para MySQL está no arquivo data/lojasacme.mysql.sql

Para usar um banco SQLite, o conteúdo do arquivo deve ser este:

```php
<?php
return [
    'db' => [
        'driver' => 'Pdo_Sqlite',
        'database' => __DIR__ . '/../../data/acme.db'
    ]
];
```

O script para geração das tabelas para SQLite está no arquivo data/lojasacme.sqlite.sql


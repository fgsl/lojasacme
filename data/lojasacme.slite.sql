--
-- Database: 'acme'
--

-- --------------------------------------------------------

--
-- Estrutura da tabela 'itens'
--

CREATE TABLE 'itens' (
  'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'pedido_id' INTEGER NOT NULL,
  'produto_id' INTEGER NOT NULL,
  'valor' double NOT NULL,
  'quantidade' INTEGER NOT NULL
);

-- --------------------------------------------------------

--
-- Estrutura da tabela 'pedidos'
--

CREATE TABLE 'pedidos' (
  'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'codigo' text
);

-- --------------------------------------------------------

--
-- Estrutura da tabela 'produtos'
--

CREATE TABLE 'produtos' (
  'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'nome' varchar(80) NOT NULL,
  'valor' double NOT NULL,
  'quantidade' int(11) NOT NULL
);

-- --------------------------------------------------------

--
-- Estrutura da tabela 'usuarios'
--

CREATE TABLE 'usuarios' (
  'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'cpf' varchar(11) NOT NULL,
  'email' varchar(80) NOT NULL,   
  'senha' varchar(255) NOT NULL
);


-- --------------------------------------------------------
--
-- Insere alguns produtos
--

INSERT INTO 'produtos' ('nome','valor','quantidade') VALUES ('extrato de energia volátil',10.45,30);
INSERT INTO 'produtos' ('nome','valor','quantidade') VALUES ('pílula de nanicolina',2.99,20);
INSERT INTO 'produtos' ('nome','valor','quantidade') VALUES ('marreta biônica',54.89,7);
INSERT INTO 'produtos' ('nome','valor','quantidade') VALUES ('peruca de sansão',23.65,10);
INSERT INTO 'produtos' ('nome','valor','quantidade') VALUES ('manopla do infinito',278.90,1);
INSERT INTO 'produtos' ('nome','valor','quantidade') VALUES ('bateria energética',74.23,7200);
INSERT INTO 'produtos' ('nome','valor','quantidade') VALUES ('espada de ébano',199.99,12);
INSERT INTO 'produtos' ('nome','valor','quantidade') VALUES ('guia do mochileiro das galáxias',32.99,150);

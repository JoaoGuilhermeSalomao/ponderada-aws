## Arquivos

### SamplePage.php
- **Descrição**: Este é o script PHP principal que:
  - Conecta-se a um banco de dados PostgreSQL usando detalhes de conexão do arquivo `dbinfo.inc`.
  - Cria e verifica a existência das tabelas `EMPLOYEES`, `UNIDADES` e `PRODUCTS`.
  - Fornece formulários para adicionar novos funcionários, unidades e produtos.
  - Exibe os dados atuais de todas as tabelas em tabelas HTML.
  - Inclui funções para:
    - Adicionar funcionários à tabela `EMPLOYEES`.
    - Adicionar unidades à tabela `UNIDADES`.
    - Adicionar produtos à tabela `PRODUCTS`.
    - Verificar a existência das tabelas e criá-las se não existirem.
    - Verificar a existência de tabelas no banco de dados.

### tabela.sql
- **Descrição**: Este arquivo SQL contém o esquema para criar a tabela `UNIDADES`:
```
CREATE TABLE UNIDADES (
ID VARCHAR(10) PRIMARY KEY,
QUANTIDADE_FUNCIONARIOS INTEGER,
ENDERECO_UNIDADE VARCHAR(255),
DATA_FUNDAÇÃO DATE,
GERENTE_UNIDADE VARCHAR(255)
);
```
- **Uso**: Este arquivo pode ser usado para criar manualmente a tabela `UNIDADES` no banco de dados PostgreSQL ou pode ser executado através de uma ferramenta de gerenciamento de banco de dados ou script.

### inc/dbinfo.inc
- **Descrição**: Este arquivo contém as informações de conexão com o banco de dados:
```
<?php define('DB_SERVER', 'seu_endereco_servidor'); define('DB_DATABASE', 'seu_nome_banco_de_dados'); define('DB_USERNAME', 'seu_usuario'); define('DB_PASSWORD', 'sua_senha'); ?>
```

### `register_product.php`
- **Descrição**: Este arquivo contém o formulário para cadastrar novos produtos e a função para adicionar produtos à tabela `PRODUCTS`.

### `list_products.php`
- **Descrição**: Este arquivo exibe os dados da tabela `PRODUCTS` em uma tabela HTML.
# Projeto Final de PHP

## Tema do Sistema
Gerenciador Pessoal de Filmes Favoritos

## Visão Geral do Projeto
Este é um sistema web desenvolvido em PHP com MySQL que permite aos usuários criar e gerenciar sua própria coleção de filmes favoritos. O projeto demonstra funcionalidades essenciais de um aplicativo web, desde a autenticação de usuários até a manipulação de dados.

## Principais Funcionalidades
* **Autenticação Completa:** Cadastro de novos usuários com validação de dados (incluindo verificação de login/e-mail existentes) e sistema de login seguro.
* **Gerenciamento de Sessão:** Controle de acesso a áreas restritas do sistema, garantindo que apenas usuários autenticados possam interagir com seus dados.
* **Gestão de Filmes (CRUD):**
    * **Cadastro:** Adicione novos filmes com título e descrição (sinopse), associados automaticamente ao usuário logado.
    * **Listagem:** Visualize todos os filmes cadastrados pelo usuário, exibidos em uma página dedicada.
    * **Edição:** Altere as informações de filmes existentes, com validação de propriedade (o usuário só pode editar seus próprios filmes).
    * **Exclusão:** Remova filmes da coleção pessoal do usuário.
* **Segurança Robusta:** Utiliza `prepared statements` para todas as interações com o banco de dados (prevenindo SQL Injection) e `password_hash()` para o armazenamento seguro de senhas.
* **Interface Amigável:** Design baseado em CSS externo para uma experiência de usuário clara e visualmente agradável.

## Tecnologias Utilizadas
* **Backend:** PHP (com extensão `mysqli` para banco de dados)
* **Banco de Dados:** MySQL/MariaDB
* **Frontend:** HTML5, CSS3
* **Controle de Versão:** Git

## Credenciais de Teste
Para facilitar a avaliação, utilize as seguintes credenciais de teste (após a configuração e possível cadastro inicial via página de cadastro):

* **Login:** Sr.cinéfilo
* **Senha:** 123456

## Instruções de Instalação e Execução

### 1. Pré-requisitos
Certifique-se de ter um ambiente de desenvolvimento web configurado (como XAMPP, WAMP, MAMP ou LAMP) com:
* Servidor web (Apache) em execução.
* PHP (preferencialmente versão 7.x ou superior) em execução.
* Servidor de banco de dados (MySQL/MariaDB) em execução.

### 2. Configuração do Banco de Dados
* Acesse seu gerenciador de banco de dados (ex: phpMyAdmin via `http://localhost/phpmyadmin/`).
* **Importe o script `sql/criar_banco.sql`** (localizado na pasta `sql/` do projeto). Este script irá criar o banco de dados **`projetofilmes.php`** (se ainda não existir) e gerar as tabelas `usuarios` e `itens` dentro dele.
* Edite o arquivo `includes/conexao.php` para atualizar as credenciais de acesso ao seu MySQL (`$host`, `$usuario_bd`, `$senha_bd`, `$nome_bd`), garantindo que `$nome_bd` seja **`'projetofilmes.php'`** de acordo com sua configuração.

### 3. Configuração do Projeto
* Copie a pasta completa do projeto (`projeto-sexta-Filmes-Favoritos-site`) para o diretório de documentos do seu servidor web (ex: `C:\xampp\htdocs\projeto-sexta-Filmes-Favoritos-site` ou `/var/www/html/projeto-sexta-Filmes-Favoritos-site`).

### 4. Acesso ao Sistema
* Abra seu navegador web e acesse o projeto pela URL: `http://localhost/projeto-sexta-Filmes-Favoritos-site/`

## Aluno
- Gabryel Rocha
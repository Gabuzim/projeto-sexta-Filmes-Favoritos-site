# Projeto Final de PHP

## Tema do Sistema
Gerenciador Pessoal de Filmes Favoritos

## Resumo do Funcionamento
Este é um sistema web desenvolvido em PHP com conexão a banco de dados MySQL que permite aos usuários gerenciar sua coleção de filmes favoritos. As funcionalidades incluem:
* **Cadastro e Autenticação de Usuários:** Usuários podem se registrar com login, senha e e-mail, e acessar o sistema com credenciais válidas. O acesso a áreas restritas é controlado por sessão.
* **Gestão de Filmes (CRUD):** Após o login, o usuário pode adicionar novos filmes à sua lista pessoal, visualizar todos os filmes cadastrados, e também editar ou excluir filmes que ele mesmo registrou. Cada filme é associado ao usuário que o cadastrou.
* **Validação e Segurança:** O sistema implementa validação de campos obrigatórios e utiliza prepared statements para todas as interações com o banco de dados , prevenindo SQL Injection. Senhas são armazenadas como hash.
* **Estética:** A interface utiliza CSS externo para uma apresentação visual agradável e usabilidade.

## Usuário e Senha de Teste
Para facilitar a avaliação, utilize as seguintes credenciais de teste (após a instalação e possível cadastro inicial):

**Login:** Sr.cinéfilo
**Senha:** 123456

## Instruções de Instalação e Execução

### 1. Configuração do Banco de Dados
* Acesse seu gerenciador de banco de dados (ex: phpMyAdmin) e crie um novo banco de dados. Nome sugerido: `projeto_php`.
* Importe o script `sql/criar_banco.sql` para este banco de dados. Este script criará as tabelas `usuarios` e `itens`.
* Edite o arquivo `includes/conexao.php` para configurar as credenciais de acesso ao seu MySQL (`$host`, `$usuario_bd`, `$senha_bd`, `$nome_bd`).

### 2. Configuração do Projeto
* Copie a pasta `seuprojeto` inteira para o diretório de documentos do seu servidor web (ex: `htdocs` no XAMPP/WAMP, ou `/var/www/html` no Linux).
* Certifique-se de que o servidor web (Apache) e o MySQL/MariaDB estejam em execução.

### 3. Acesso ao Sistema
* Abra seu navegador e acesse: `http://localhost/meuprojetosexta/`

## Aluno
- Gabryel Rocha
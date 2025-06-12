<?php

require_once 'includes/conexao.php';
require_once 'includes/funcoes.php';

// Protege a página: verifica se o usuário está logado 
verificar_login();

// Obtém o nome de usuário da sessão para exibir na tela
$usuario_login = $_SESSION['usuario_login'] ?? 'Usuário';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Seu Projeto PHP</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="container">
        <h2>Bem-vindo(a) ao Dashboard, <?php echo html_escape($usuario_login); ?>!</h2>
        <?php mostrar_mensagem(); ?>
        <p class="text-center">Aqui você pode gerenciar seus Filmes Preferidos.</p>

        <nav>
            <ul style="list-style: none; padding: 0; text-align: center;">
                <li style="margin-bottom: 10px;"><a href="itens.php" class="btn-primary">Ver Meus Filmes Favoritos</a></li>
                <li style="margin-bottom: 10px;"><a href="novo_item.php" class="btn-primary">Adicionar Novo Filme</a></li>
                <li style="margin-bottom: 10px;"><a href="logout.php" class="btn-secondary">Sair</a></li>
            </ul>
        </nav>
    </div>
</body>

</html>
<?php


require_once 'includes/conexao.php';
require_once 'includes/funcoes.php';

// Redireciona se o usuário já estiver logado
if (isset($_SESSION['usuario_id'])) {
    redirecionar('dashboard.php');
}

$erro_login = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login_digitado = $_POST['login'] ?? '';
    $senha_digitada = $_POST['senha'] ?? '';

    // Validação básica dos campos
    if (empty(trim($login_digitado)) || empty(trim($senha_digitada))) {
        $erro_login = "Login e senha são obrigatórios.";
    } else {
        // Prepara a consulta para evitar SQL Injection
        $stmt = $conexao->prepare("SELECT id, login, senha FROM usuarios WHERE login = ?");
        if ($stmt) {
            $stmt->bind_param("s", $login_digitado);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows === 1) {
                $stmt->bind_result($id_usuario, $login_bd, $senha_hash_bd);
                $stmt->fetch();

                // Verifica a senha hasheada
                if (password_verify($senha_digitada, $senha_hash_bd)) {
                    $_SESSION['usuario_id'] = $id_usuario; // Armazena o ID do usuário na sessão 
                    $_SESSION['usuario_login'] = $login_bd;
                    exibir_mensagem('success', 'Login realizado com sucesso!');
                    redirecionar('dashboard.php'); // Redireciona para o dashboard 
                } else {
                    $erro_login = "Login ou senha inválidos."; // Senha incorreta
                }
            } else {
                $erro_login = "Login ou senha inválidos."; // Login não encontrado
            }
            $stmt->close();
        } else {
            $erro_login = "Erro interno ao preparar a consulta.";
        }
    }
}

$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - filmes favoritos</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>

</html>
<body>
    <div class="container">
        <h2>Bem-vindo ao sistema de Filmes Favoritos!</h2>
        <h2>Faça seu Login</h2>
        <?php mostrar_mensagem(); ?>
        <?php if (!empty($erro_login)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo html_escape($erro_login); ?>
            </div>
        <?php endif; ?>
        <form action="index.php" method="POST">
            <div>
                <label for="login">Login:</label>
                <input type="text" id="login" name="login" required>
            </div>
            <div>
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <div>
                <input type="submit" value="Entrar">
            </div>
        </form>
        <p class="text-center">Ainda não tem uma conta? <a href="cadastro.php">Cadastre-se aqui</a>.</p>
    </div>
</body>

<?php


require_once 'includes/conexao.php';
require_once 'includes/funcoes.php';

$mensagem_cadastro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login_digitado = $_POST['login'] ?? '';
    $senha_digitada = $_POST['senha'] ?? '';
    $email_digitado = $_POST['email'] ?? '';

    // Validação de campos obrigatórios 
    if (!validar_campos_obrigatorios($_POST, ['login', 'senha', 'email'])) {
        $mensagem_cadastro = "Todos os campos são obrigatórios.";
        exibir_mensagem('danger', $mensagem_cadastro);
    } elseif (!filter_var($email_digitado, FILTER_VALIDATE_EMAIL)) {
        $mensagem_cadastro = "E-mail inválido.";
        exibir_mensagem('danger', $mensagem_cadastro);
    } else {
        // Verificar se login ou email já existem 
        $stmt_check = $conexao->prepare("SELECT id FROM usuarios WHERE login = ? OR email = ?");
        if ($stmt_check) {
            $stmt_check->bind_param("ss", $login_digitado, $email_digitado);
            $stmt_check->execute();
            $stmt_check->store_result();

            if ($stmt_check->num_rows > 0) {
                $mensagem_cadastro = "Login ou e-mail já cadastrado.";
                exibir_mensagem('warning', $mensagem_cadastro);
            } else {
                // Hashear a senha antes de salvar no banco de dados
                $senha_hash = password_hash($senha_digitada, PASSWORD_DEFAULT);

                // Inserir novo usuário
                $stmt_insert = $conexao->prepare("INSERT INTO usuarios (login, senha, email) VALUES (?, ?, ?)");
                if ($stmt_insert) {
                    $stmt_insert->bind_param("sss", $login_digitado, $senha_hash, $email_digitado);
                    if ($stmt_insert->execute()) {
                        $mensagem_cadastro = "Usuário cadastrado com sucesso! Agora você pode fazer login.";
                        exibir_mensagem('success', $mensagem_cadastro);
                        // redirecionar para a página de login
                        redirecionar('index.php');
                    } else {
                        $mensagem_cadastro = "Erro ao cadastrar usuário: " . $stmt_insert->error;
                        exibir_mensagem('danger', $mensagem_cadastro);
                    }
                    $stmt_insert->close();
                } else {
                    $mensagem_cadastro = "Erro interno ao preparar a inserção.";
                    exibir_mensagem('danger', $mensagem_cadastro);
                }
            }
            $stmt_check->close();
        } else {
            $mensagem_cadastro = "Erro interno ao verificar login/email.";
            exibir_mensagem('danger', $mensagem_cadastro);
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
    <title>Cadastro - Seu Projeto PHP</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="container">
        <h2>Cadastro de Novo Usuário</h2>
        <?php mostrar_mensagem(); ?>
        <form action="cadastro.php" method="POST">
            <div>
                <label for="login">Login:</label>
                <input type="text" id="login" name="login" required value="<?php echo html_escape($login_digitado ?? ''); ?>">
            </div>
            <div>
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required value="<?php echo html_escape($email_digitado ?? ''); ?>">
            </div>
            <div>
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <div>
                <input type="submit" value="Cadastrar">
            </div>
        </form>
        <p class="text-center">Já tem uma conta? <a href="index.php">Faça login aqui</a>.</p>
    </div>
</body>

</html>
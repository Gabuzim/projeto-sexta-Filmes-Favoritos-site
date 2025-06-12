<?php

require_once 'includes/conexao.php';
require_once 'includes/funcoes.php';

// Protege a página: verifica se o usuário está logado 
verificar_login();

$titulo = '';
$Sinopse = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $Sinopse = $_POST['Sinopse'] ?? '';
    $usuario_id = $_SESSION['usuario_id']; // ID do usuário logado 

    // Validação de campos obrigatórios 
    if (!validar_campos_obrigatorios($_POST, ['titulo', 'Sinopse'])) {
        exibir_mensagem('danger', 'Título e descrição são obrigatórios.');
    } else {
        // Inserir o novo item no banco de dados
        $stmt = $conexao->prepare("INSERT INTO itens (usuario_id, titulo, Sinopse) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("iss", $usuario_id, $titulo, $Sinopse);
            if ($stmt->execute()) {
                exibir_mensagem('success', 'Item cadastrado com sucesso!');
                redirecionar('itens.php'); // Redireciona para a lista de itens
            } else {
                exibir_mensagem('danger', 'Erro ao cadastrar item: ' . $stmt->error);
            }
            $stmt->close();
        } else {
            exibir_mensagem('danger', 'Erro interno ao preparar o cadastro do item.');
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
    <title>Novo Item - Seu Projeto PHP</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="container">
        <h2>Cadastrar Filme Favorito</h2>
        <?php mostrar_mensagem(); ?>
        <form action="novo_item.php" method="POST">
            <div>
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required value="<?php echo html_escape($titulo); ?>">
            </div>
            <div>
                <label for="Sinopse">Sinopse:</label>
                <textarea id="Sinopse" name="Sinopse" rows="5" required><?php echo html_escape($Sinopse); ?></textarea>
            </div>
            <div>
                <input type="submit" value="Cadastrar Item">
            </div>
        </form>
        <p class="text-center" style="margin-top: 20px;"><a href="itens.php" class="btn-secondary">Voltar para a Lista de Itens</a></p>
    </div>
</body>
</html>
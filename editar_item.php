<?php

require_once 'includes/conexao.php';
require_once 'includes/funcoes.php';

// Protege a página: verifica se o usuário está logado 
verificar_login();

$item_id = $_GET['id'] ?? null;
$usuario_id = $_SESSION['usuario_id'];

$item = null; // Variável para armazenar os dados do Filme

// Se não houver ID na URL, redireciona
if (!$item_id || !is_numeric($item_id)) {
    exibir_mensagem('danger', 'ID do Filme inválido.');
    redirecionar('itens.php');
}

// Lógica para carregar os dados do filme ao carregar a página
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Buscar o Filme no banco de dados e verificar se pertence ao usuário logado 
    $stmt = $conexao->prepare("SELECT id, titulo, Sinopse FROM itens WHERE id = ? AND usuario_id = ?");
    if ($stmt) {
        $stmt->bind_param("ii", $item_id, $usuario_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        if ($resultado->num_rows === 1) {
            $item = $resultado->fetch_assoc();
        } else {
            exibir_mensagem('danger', 'Filme não encontrado ou você não tem permissão para editá-lo.');
            redirecionar('itens.php');
        }
        $stmt->close();
    } else {
        exibir_mensagem('danger', 'Erro interno ao buscar Filme para edição.');
        redirecionar('itens.php');
    }
}

// Lógica para processar a submissão do formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id_post = $_POST['item_id'] ?? null;
    $titulo_novo = $_POST['titulo'] ?? '';
    $Sinopse_nova = $_POST['Sinopse'] ?? '';

    // Garante que o ID do Filme enviado no POST é o mesmo que está sendo editado
    if ($item_id_post != $item_id) {
        exibir_mensagem('danger', 'Erro de segurança: ID do Filme inconsistente.');
        redirecionar('itens.php');
    }

    // Validação de campos obrigatórios 
    if (!validar_campos_obrigatorios($_POST, ['titulo', 'Sinopse'])) {
        exibir_mensagem('danger', 'Título e descrição são obrigatórios.');
    } else {
        // Atualizar o Filme no banco de dados
        $stmt = $conexao->prepare("UPDATE itens SET titulo = ?, Sinopse = ? WHERE id = ? AND usuario_id = ?");
        if ($stmt) {
            $stmt->bind_param("ssii", $titulo_novo, $Sinopse_nova, $item_id, $usuario_id);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    exibir_mensagem('success', 'Filme atualizado com sucesso!');
                } else {
                    exibir_mensagem('info', 'Nenhuma alteração foi feita no Filme.');
                }
                redirecionar('itens.php'); // Redireciona para a lista de itens
            } else {
                exibir_mensagem('danger', 'Erro ao atualizar Filme: ' . $stmt->error);
            }
            $stmt->close();
        } else {
            exibir_mensagem('danger', 'Erro interno ao preparar a atualização do Filme.');
        }
    }
    // Re-carregar os dados para exibir no formulário caso haja erro de validação
    $item['titulo'] = $titulo_novo;
    $item['Sinopse'] = $Sinopse_nova;
}

$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> |Editar Filme| </title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="container">
        <h2>Editar Filme</h2>
        <?php mostrar_mensagem(); ?>

        <?php if ($item): ?>
            <form action="editar_item.php?id=<?php echo html_escape($item['id']); ?>" method="POST">
                <input type="hidden" name="item_id" value="<?php echo html_escape($item['id']); ?>">
                <div>
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" required value="<?php echo html_escape($item['titulo']); ?>">
                </div>
                <div>
                    <label for="Sinopse">Descrição:</label>
                    <textarea id="Sinopse" name="Sinopse" rows="5" required><?php echo html_escape($item['Sinopse']); ?></textarea>
                </div>
                <div>
                    <input type="submit" value="Salvar Alterações">
                </div>
            </form>
        <?php endif; ?>
        <p class="text-center" style="margin-top: 20px;"><a href="itens.php" class="btn-secondary">Voltar para a Lista de Itens</a></p>
    </div>
</body>

</html>
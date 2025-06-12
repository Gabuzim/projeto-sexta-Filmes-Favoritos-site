<?php

require_once 'includes/conexao.php';
require_once 'includes/funcoes.php';

verificar_login(); // Protege a página

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $item_id = $_GET['id'];
    $usuario_id = $_SESSION['usuario_id'];

    // Prepara a exclusão, verificando se o item pertence ao usuário logado
    $stmt = $conexao->prepare("DELETE FROM itens WHERE id = ? AND usuario_id = ?");
    if ($stmt) {
        $stmt->bind_param("ii", $item_id, $usuario_id);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                exibir_mensagem('success', 'Item excluído com sucesso!');
            } else {
                exibir_mensagem('warning', 'Item não encontrado ou não pertence ao usuário logado.');
            }
        } else {
            exibir_mensagem('danger', 'Erro ao excluir item: ' . $stmt->error);
        }
        $stmt->close();
    } else {
        exibir_mensagem('danger', 'Erro interno ao preparar a exclusão.');
    }
} else {
    exibir_mensagem('danger', 'ID do item inválido.');
}

$conexao->close();
redirecionar('itens.php');
?>
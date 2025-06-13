<?php

require_once 'includes/conexao.php';
require_once 'includes/funcoes.php';

// Protege a página: verifica se o usuário está logado 
verificar_login();

$usuario_id = $_SESSION['usuario_id'];
$itens = [];

// Busca os itens associados ao usuário logado 
$stmt = $conexao->prepare("SELECT id, titulo, Sinopse, data_criacao FROM itens WHERE usuario_id = ? ORDER BY data_criacao DESC");
if ($stmt) {
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while ($linha = $resultado->fetch_assoc()) {
        $itens[] = $linha;
    }
    $stmt->close();
} else {
    exibir_mensagem('danger', 'Erro ao buscar itens: ' . $conexao->error);
}

$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Itens - Seu Projeto PHP</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="container">
        <h2>Meus Filmes: </h2>
        <?php mostrar_mensagem(); ?>

        <p><a href="novo_item.php" class="btn-primary">Adicionar Filme</a></p>

        <?php if (empty($itens)): ?>
            <p class="text-center">Você ainda não possui seus filmes cadastrados.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Sinopse</th>
                        <th>Data de inclusão </th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($itens as $item): ?>
                        <tr>
                            <td><?php echo html_escape($item['titulo']); ?></td>
                            <td><?php echo html_escape($item['Sinopse']); ?></td>
                            <td><?php echo html_escape(date('d/m/Y H:i', strtotime($item['data_criacao']))); ?></td>
                            <td class="table-actions">
                                <a href="editar_item.php?id=<?php echo html_escape($item['id']); ?>" class="btn btn-edit">Editar</a>
                                <a href="#" class="btn btn-delete" onclick="confirmDelete(<?php echo $item['id']; ?>)">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <p class="text-center" style="margin-top: 20px;"><a href="dashboard.php" class="btn-secondary">Voltar ao Dashboard</a></p>
    </div>

    <script>
        function confirmDelete(itemId) {
            if (confirm('Tem certeza que deseja excluir este item?')) {
                window.location.href = 'excluir_item.php?id=' + itemId;
            }
        }
    </script>
</body>

</html>
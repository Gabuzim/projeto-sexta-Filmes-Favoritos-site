<?php


// Inicia a sessão se ainda não estiver iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Função para redirecionar o usuário para uma URL específica
function redirecionar($url) {
    header("Location: " . $url);
    exit();
}

// Função para verificar se o usuário está logado, Se não estiver, redireciona para a página de login
function verificar_login() {
    if (!isset($_SESSION['usuario_id'])) {
        exibir_mensagem('danger', 'Você precisa estar logado para acessar esta página.');
        redirecionar('index.php'); // Redireciona para o formulário de login
    }
}

// Função para validar se os campos obrigatórios de um array foram preenchidos
function validar_campos_obrigatorios($dados, $campos_obrigatorios) {
    foreach ($campos_obrigatorios as $campo) {
        if (!isset($dados[$campo]) || trim($dados[$campo]) === '') {
            return false; // Retorna falso se encontrar um campo vazio
        }
    }
    return true; // Retorna verdadeiro se todos os campos estiverem preenchidos
}

// Função para exibir mensagens de sucesso ou erro usando a sessão
function exibir_mensagem($tipo, $texto) {
    // Tipos de mensagem: 'success', 'danger', 'warning', 'info'
    $_SESSION['mensagem'] = ['tipo' => $tipo, 'texto' => $texto];
}

// Função para mostrar a mensagem armazenada na sessão e limpar
function mostrar_mensagem() {
    if (isset($_SESSION['mensagem'])) {
        $mensagem = $_SESSION['mensagem'];
        echo '<div class="alert alert-' . htmlspecialchars($mensagem['tipo']) . ' mt-3" role="alert">' . htmlspecialchars($mensagem['texto']) . '</div>';
        unset($_SESSION['mensagem']); // Limpa a mensagem após exibir
    }
}

// Função para escapar dados para exibição em HTML (prevenção de XSS)
function html_escape($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

?>
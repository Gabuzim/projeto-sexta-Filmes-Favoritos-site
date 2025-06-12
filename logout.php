<?php

require_once 'includes/funcoes.php';

// Inicia a sessão se ainda não estiver iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Destrói todas as variáveis de sessão
$_SESSION = array();

// Se for preciso, apaga também o cookie de sessão.
// Nota: Isso destruirá a sessão e não apenas os dados da sessão!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destrói a sessão
session_destroy(); // 

exibir_mensagem('info', 'Você foi desconectado.');
redirecionar('index.php'); // Redireciona para a página de login
?>
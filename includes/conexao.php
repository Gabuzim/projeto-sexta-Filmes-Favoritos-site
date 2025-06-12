<?php


$host = "localhost"; 
$usuario_bd = "root"; 
$senha_bd = "";     
$nome_bd = "projetofilmes.php"; 


$conexao = new mysqli($host, $usuario_bd, $senha_bd, $nome_bd);


if ($conexao->connect_error) {
    die("Erro de conexão com o banco de dados: " . $conexao->connect_error);
}


$conexao->set_charset("utf8mb4");

?>
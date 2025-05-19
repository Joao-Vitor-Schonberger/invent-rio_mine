<?php
session_start(); // Inicia a sessão para controlar o login do usuário

function estaLogado() {
    return isset($_SESSION['usuario_id']);
}

function verificarLogin() {
    if (!estaLogado()) {
        header("Location: index.php");
        exit();
    }
}

function escapar($dado) {
    global $conexao;
    return mysqli_real_escape_string($conexao, $dado);
}
?>
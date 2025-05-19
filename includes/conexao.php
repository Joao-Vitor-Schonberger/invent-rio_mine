<?php
$servidor = "localhost";
$usuario = "root"; // Usuário padrão do MySQL no USBWebserver
$senha = "usbw";     // Senha padrão do MySQL no USBWebserver (geralmente vazia)
$banco = "inventario_minecraft";

$conexao = new mysqli($servidor, $usuario, $senha, $banco);

if ($conexao->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
}
?>
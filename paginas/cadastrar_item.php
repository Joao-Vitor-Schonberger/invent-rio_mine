<?php
require_once("../includes/conexao.php");
require_once("../includes/funcoes.php");
verificarLogin();

$usuario_id = $_SESSION['usuario_id'];
$mensagem = "";
$erro = "";

if (isset($_POST['salvar_item'])) {
    $nome_item = escapar($_POST['nome_item']);
    $quantidade_adicionada = intval($_POST['quantidade']);
    $descricao = escapar($_POST['descricao']);

    if (!empty($nome_item)) {
        // Primeiro, verificar se o item já existe para este usuário
        $query_verificar = "SELECT id, quantidade FROM inventario WHERE usuario_id = $usuario_id AND nome_item = '$nome_item'";
        $resultado_verificar = $conexao->query($query_verificar);

        if ($resultado_verificar->num_rows > 0) {
            // Item já existe, então vamos somar a quantidade
            $item_existente = $resultado_verificar->fetch_assoc();
            $nova_quantidade = $item_existente['quantidade'] + $quantidade_adicionada;
            $id_item_existente = $item_existente['id'];

            $query_atualizar = "UPDATE inventario SET quantidade = $nova_quantidade, descricao = '$descricao' WHERE id = $id_item_existente";
            if ($conexao->query($query_atualizar) === TRUE) {
                $mensagem = "Quantidade do item '" . htmlspecialchars($nome_item) . "' atualizada com sucesso!";
            } else {
                $erro = "Erro ao atualizar a quantidade do item: " . $conexao->error;
            }
        } else {
            // Item não existe, então vamos cadastrá-lo normalmente
            $query_inserir = "INSERT INTO inventario (usuario_id, nome_item, quantidade, descricao) VALUES ($usuario_id, '$nome_item', $quantidade_adicionada, '$descricao')";
            if ($conexao->query($query_inserir) === TRUE) {
                $mensagem = "Item '" . htmlspecialchars($nome_item) . "' cadastrado com sucesso!";
            } else {
                $erro = "Erro ao cadastrar o item: " . $conexao->error;
            }
        }
    } else {
        $erro = "O nome do item é obrigatório.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Item - Inventário Minecraft</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="bg-light cadastrar">
    <div class="container mt-5 verdeClaro">
        <h1>Cadastrar Novo Item</h1>

        <?php if ($mensagem): ?>
            <div class="alert alert-success"><?php echo $mensagem; ?></div>
        <?php endif; ?>
        <?php if ($erro): ?>
            <div class="alert alert-danger"><?php echo $erro; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="nome_item">Nome do Item:</label>
                <input type="text" class="form-control" id="nome_item" name="nome_item" required>
            </div>
            <div class="form-group">
                <label for="quantidade">Quantidade:</label>
                <input type="number" class="form-control" id="quantidade" name="quantidade" value="1" min="1">
            </div>
            <div class="form-group">
                <label for="descricao">Descrição (Opcional):</label>
                <textarea class="form-control" id="descricao" name="descricao"></textarea>
            </div>
        <button type="submit" class="btn btn-primary verdeEscuro" name="salvar_item">Salvar Item</button>
            <a href="inventario.php" class="btn btn-secondary ml-2">Cancelar</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
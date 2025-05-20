<?php
require_once("../includes/conexao.php");
require_once("../includes/funcoes.php");
verificarLogin();

$usuario_id = $_SESSION['usuario_id'];
$mensagem = "";
$erro = "";

// Buscar informações do item para edição
if (isset($_GET['id'])) {
    $id_item = escapar($_GET['id']);
    $query_item = "SELECT * FROM inventario WHERE id = $id_item AND usuario_id = $usuario_id";
    $resultado_item = $conexao->query($query_item);
    if ($resultado_item->num_rows == 1) {
        $item = $resultado_item->fetch_assoc();
    } else {
        // Item não encontrado ou não pertence ao usuário
        header("Location: inventario.php");
        exit();
    }
} else {
    // ID do item não fornecido
    header("Location: inventario.php");
    exit();
}

// Processar atualização do item
if (isset($_POST['atualizar_item'])) {
    $id_item_atualizar = escapar($_POST['id_item']);
    $nome_item = escapar($_POST['nome_item']);
    $quantidade = intval($_POST['quantidade']);
    $descricao = escapar($_POST['descricao']);

    if (!empty($nome_item)) {
        $query_atualizar = "UPDATE inventario SET nome_item = '$nome_item', quantidade = $quantidade, descricao = '$descricao' WHERE id = $id_item_atualizar AND usuario_id = $usuario_id";
        if ($conexao->query($query_atualizar) === TRUE) {
            $mensagem = "Item atualizado com sucesso!";
            // Recarrega as informações atualizadas do banco
            $query_item = "SELECT * FROM inventario WHERE id = $id_item_atualizar AND usuario_id = $usuario_id";
            $resultado_item = $conexao->query($query_item);
            $item = $resultado_item->fetch_assoc();
        } else {
            $erro = "Erro ao atualizar o item: " . $conexao->error;
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
    <title>Editar Item - Inventário Minecraft</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="bg-light editar">
    <div class="container mt-5 verdeClaro">
        <h1>Editar Item</h1>

        <?php if ($mensagem): ?>
            <div class="alert alert-success"><?php echo $mensagem; ?></div>
        <?php endif; ?>
        <?php if ($erro): ?>
            <div class="alert alert-danger"><?php echo $erro; ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="id_item" value="<?php echo htmlspecialchars($item['id']); ?>">
            <div class="form-group">
                <label for="nome_item">Nome do Item:</label>
                <input type="text" class="form-control" id="nome_item" name="nome_item" value="<?php echo htmlspecialchars($item['nome_item']); ?>" required>
            </div>
            <div class="form-group">
                <label for="quantidade">Quantidade:</label>
                <input type="number" class="form-control" id="quantidade" name="quantidade" value="<?php echo htmlspecialchars($item['quantidade']); ?>" min="1">
            </div>
            <div class="form-group">
                <label for="descricao">Descrição (Opcional):</label>
                <textarea class="form-control" id="descricao" name="descricao"><?php echo htmlspecialchars($item['descricao']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary verdeEscuro" name="atualizar_item">Salvar Alterações</button>
            <a href="inventario.php" class="btn btn-secondary ml-2">Cancelar</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
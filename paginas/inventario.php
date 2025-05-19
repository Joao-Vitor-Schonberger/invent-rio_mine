<?php
require_once("../includes/conexao.php");
require_once("../includes/funcoes.php");
verificarLogin();

$usuario_id = $_SESSION['usuario_id'];

// Buscar itens do inventário do usuário
$query = "SELECT * FROM inventario WHERE usuario_id = $usuario_id";
$resultado = $conexao->query($query);
$itens = $resultado->fetch_all(MYSQLI_ASSOC);

// Processar exclusão de item
if (isset($_GET['excluir'])) {
    $id_excluir = escapar($_GET['excluir']);
    $query_excluir = "DELETE FROM inventario WHERE id = $id_excluir AND usuario_id = $usuario_id";
    if ($conexao->query($query_excluir) === TRUE) {
        $mensagem = "Item excluído com sucesso!";
    } else {
        $erro = "Erro ao excluir o item: " . $conexao->error;
    }
    header("Location: inventario.php"); // Recarrega a página para atualizar a lista
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventário Minecraft</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Seu Inventário Minecraft</h1>
        <p><a href="cadastrar_item.php" class="btn btn-success mb-3">Adicionar Item</a></p>

        <?php if (isset($mensagem)): ?>
            <div class="alert alert-success"><?php echo $mensagem; ?></div>
        <?php endif; ?>
        <?php if (isset($erro)): ?>
            <div class="alert alert-danger"><?php echo $erro; ?></div>
        <?php endif; ?>

        <?php if (count($itens) > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($itens as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['nome_item']); ?></td>
                            <td><?php echo htmlspecialchars($item['quantidade']); ?></td>
                            <td><?php echo htmlspecialchars($item['descricao']); ?></td>
                            <td>
                                <a href="editar_item.php?id=<?php echo $item['id']; ?>" class="btn btn-sm btn-primary">Editar</a>
                                <a href="inventario.php?excluir=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este item?')">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Seu inventário está vazio.</p>
        <?php endif; ?>

        <p><a href="../index.php" class="btn btn-secondary mt-3">Sair</a></p>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
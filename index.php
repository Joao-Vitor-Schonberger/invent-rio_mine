<?php
require_once("includes/conexao.php");
require_once("includes/funcoes.php");

$erro_login = "";
$erro_cadastro = "";
$mensagem_cadastro = "";

// Processar Login
if (isset($_POST['login'])) {
    $email = escapar($_POST['email']);
    $senha = escapar($_POST['senha']);

    $query = "SELECT id, senha FROM usuarios WHERE email = '$email'";
    $resultado = $conexao->query($query);

    if ($resultado->num_rows == 1) {
        $usuario = $resultado->fetch_assoc();
        if ($senha == $usuario['senha']) { // Lembre-se da segurança da senha em projetos reais
            $_SESSION['usuario_id'] = $usuario['id'];
            header("Location: paginas/inventario.php");
            exit();
        } else {
            $erro_login = "Senha incorreta.";
        }
    } else {
        $erro_login = "Usuário não encontrado.";
    }
}

// Processar Cadastro
if (isset($_POST['cadastrar'])) {
    $nome = escapar($_POST['nome']);
    $email = escapar($_POST['email']);
    $senha = escapar($_POST['senha']);
    $confirmar_senha = escapar($_POST['confirmar_senha']);

    if ($senha == $confirmar_senha) {
        $query = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
        if ($conexao->query($query) === TRUE) {
            $mensagem_cadastro = "Cadastro realizado com sucesso! Faça login.";
        } else {
            $erro_cadastro = "Erro ao cadastrar: " . $conexao->error;
        }
    } else {
        $erro_cadastro = "As senhas não coincidem.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login e Cadastro - Inventário Minecraft</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .nav-tabs .nav-link {
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-light login">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4 verdeClaro">
                    <ul class="nav nav-tabs nav-justified mb-4" id="myTab" role="tablist">
                        <li class="nav-item ">
                            <a class="nav-link active " id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Login</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" id="cadastro-tab" data-toggle="tab" href="#cadastro" role="tab" aria-controls="cadastro" aria-selected="false">Cadastre-se</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active " id="login" role="tabpanel" aria-labelledby="login-tab">
                            <form method="POST">
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="senha">Senha:</label>
                                    <input type="password" class="form-control" id="senha" name="senha" required>
                                </div>
                                <?php if ($erro_login): ?>
                                    <div class="alert alert-danger"><?php echo $erro_login; ?></div>
                                <?php endif; ?>
                                <button type="submit" class="btn btn-primary btn-block verdeEscuro" name="login">Entrar</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="cadastro" role="tabpanel" aria-labelledby="cadastro-tab">
                            <form method="POST">
                                <div class="form-group">
                                    <label for="nome">Nome:</label>
                                    <input type="text" class="form-control" id="nome" name="nome" required>
                                </div>
                                <div class="form-group">
                                    <label for="email_cadastro">Email:</label>
                                    <input type="email" class="form-control" id="email_cadastro" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="senha_cadastro">Senha:</label>
                                    <input type="password" class="form-control" id="senha_cadastro" name="senha" required>
                                </div>
                                <div class="form-group">
                                    <label for="confirmar_senha">Confirmar Senha:</label>
                                    <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required>
                                </div>
                                <?php if ($erro_cadastro): ?>
                                    <div class="alert alert-danger"><?php echo $erro_cadastro; ?></div>
                                <?php endif; ?>
                                <?php if ($mensagem_cadastro): ?>
                                    <div class="alert alert-success"><?php echo $mensagem_cadastro; ?></div>
                                <?php endif; ?>
                                <button type="submit" class="btn btn-success btn-block verdeEscuro" name="cadastrar">Cadastrar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(function () {
            $('#myTab a').on('click', function (e) {
                e.preventDefault()
                $(this).tab('show')
            })
        })
    </script>
</body>
</html>
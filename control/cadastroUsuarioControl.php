<?php

require_once '../model/DTO/UsuarioDTO.php';
require_once '../model/DAO/UsuarioDAO.php';

// Iniciar a sessão para pegar o ID do administrador logado
session_start();

// Verificar se o administrador está logado e pegar o ID do administrador
if (isset($_SESSION['id_usuario'])) {
    $idAdm = $_SESSION['id_usuario'];  // O ID do administrador logado
} else {
    // Se o administrador não estiver logado, redirecionar para a página de login ou exibir erro
    echo "Você precisa estar logado como administrador para cadastrar um usuário.";
    exit(); // Encerra o script caso o administrador não esteja logado
}

// Dados do formulário de cadastro
$nome = $_POST['nome'];
$email = $_POST['email'];
$cpf = $_POST['cpf'];
$senha = $_POST['senha'];
$perfil = $_POST['perfil'];

// Cria e configura o objeto DTO
$usuarioDTO = new UsuarioDTO();
$usuarioDTO->setNome($nome);
$usuarioDTO->setEmail($email);
$usuarioDTO->setCpf($cpf);
$usuarioDTO->setSenha($senha);
$usuarioDTO->setPerfil($perfil);

// Realiza o cadastro e define a mensagem de retorno
$usuarioDAO = new UsuarioDAO();
$resultado = $usuarioDAO->cadastroUsuario($usuarioDTO, $idAdm);

if ($resultado) {
    $mensagem = "Usuário cadastrado com sucesso!";
    $status = "success";
} else {
    $mensagem = "Erro ao cadastrar o usuário.";
    $status = "error";
}

echo "<script type='text/javascript'>
        window.onload = function() {
            exibirModal('$mensagem', '$status');
        };
      </script>";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado do Cadastro</title>
    <link rel="stylesheet" href="../css/cadastroUser.css">
</head>
<body>

<!-- Modal de feedback -->
<div id="modal" class="modal">
    <h1>Resultado do Cadastro</h1>
    <p id="mensagem"></p>
    <button onclick="fecharModal()">Fechar</button>
</div>

<!-- Importa o arquivo modal.js com o código JavaScript -->
<script src="../javaScript/cadastroUser.js"></script>

<!-- Script inline para exibir o modal ao carregar a página -->
<script type="text/javascript">
    window.onload = function() {
        exibirModal('<?php echo $mensagem; ?>', '<?php echo $status; ?>');
    };
</script> 
</body>
</html>





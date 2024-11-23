<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php"); // Redireciona para a página de login
    exit;
}
?>

<?php

// pegar o id do usuario que sera alterado
// criar usuarioDAO
// chamar a função buscarusuario por id
require_once'../model/DTO/UsuarioDTO.php';
require_once'../model/DAO/UsuarioDAO.php';

$id = $_GET['id'];

// var_dump($id);

$usuarioDAO = new UsuarioDAO();

$usuario = $usuarioDAO->BuscarUsuarioPorId($id);


// echo "<pre>";
// var_dump($usuario);
 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Usuário</title>
    <link rel="stylesheet" href="../css/adm.css">
</head>
<body>

<nav class="navbar">
        <div class="system-name">
            <h3>Educa<span>Mentes</span></h3>
        </div>
        <a href="../control/logout.php" class="logout-button">Sair</a>
    </nav>

    <!-- Guia lateral -->
    <div class="sidebar">

        <div class="menu-container">
            <h3 class="menu-text">Menu</h3>
            
        </div>
        <hr>
        <br>
        <a href="formMeuperfil.php" class="sidebar-btn" onclick="showSection('perfil')">Meu Perfil</a>
        <a href="gerencia.php" class="sidebar-btn" onclick="showSection('gerencia')">Gerenciar Prefis</a>
        <a href="buscarPai.php" class="sidebar-btn">Cadastrar Alunos</a>
        <a href="formResponsavel.php" class="sidebar-btn" onclick="showSection('responsavelForm')">Cadastrar Responsável</a>
        <a href="professorForm.php" class="sidebar-btn" >Cadastrar Professor</a>
        
-

    </div>

    <div class="container-Alterar">

        <fieldset class="alterar">
            <legend>Alterar Informações do Usuário</legend>
            <form action="../control/alterarUsuarioControl.php" method="POST">
                <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">
                
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo $usuario['nome']; ?>" required>
                
                
                <label for="email">Email:</label>
                <input type="text" name="email" value="<?php echo $usuario['email']; ?>" required>
                
                <label for="cpf">CPF:</label>
                <input type="text" name="cpf" value="<?php echo $usuario['cpf']; ?>" required>
                
                <label for="senha">Senha:</label>
                <input type="password" name="senha" value="<?php echo $usuario['senha']; ?>" required>
                
                <label>Perfil:</label><br>
                <div class="perfil-container">
                    <input type="radio" id="professor" name="perfil" value="professor" 
                    <?php echo ($usuario['perfil'] === 'professor') ? 'checked' : ''; ?> required>
                    <label for="professor">Professor</label>

                    <input type="radio" id="responsavel" name="perfil" value="responsavel" 
                        <?php echo ($usuario['perfil'] === 'responsavel') ? 'checked' : ''; ?> required>
                    <label for="responsavel">Responsável</label>
                </div>
                <br><br>
                    <input type="submit" value="Alterar">
            </fieldset> 
    </div>   
          

</body>
</html>

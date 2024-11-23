<?php
require_once '../model/DAO/AdmDAO.php';

// Inicia a sessão apenas se não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário está logado como administrador
if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'administrador') {
    echo "<script>
        alert('Acesso não autorizado!');
        window.location.href = '../index.php';
    </script>";
    exit;
}

// Obtém o email do administrador logado
$emailAdministrador = $_SESSION['usuario'];

// Cria uma instância de AdmDAO para buscar os dados do administrador
$admDAO = new AdmDAO();
$dadosAdministrador = $admDAO->buscarDadosAdministrador($emailAdministrador);

// Verifica se encontrou os dados do administrador
if ($dadosAdministrador) {
    $id_usuario = $dadosAdministrador['id_Adm'];
    $nome = $dadosAdministrador['nome'];
    $email = $dadosAdministrador['email'];
    $foto = $dadosAdministrador['foto'] ?? 'default.jpg';
} else {
    echo "<script>
        alert('Dados do administrador não encontrados.');
        window.location.href = '../view/formMeuperfil.php';
    </script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEMA | VM</title>
    <link rel="stylesheet" href="../css/admPerfil.css">
</head>

<body>
    <!-- Barra de navegação -->
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
            <a href="formMeuperfil.php" class="sidebar-btn" >Meu Perfil</a>
            <a href="gerencia.php" class="sidebar-btn" >Gerenciar Prefis</a>
            <a href="buscarPai.php" class="sidebar-btn" >Cadastrar Alunos</a>
            <a href="formResponsavel.php" class="sidebar-btn" >Cadastrar Responsável</a>
            <a href="professorForm.php" class="sidebar-btn" >Cadastrar Professor</a>
            <a href="criarTurmas.php" class="sidebar-btn" >Criar Turmas</a>
            <a href="turmas.php" class="sidebar-btn" >Turmas</a>
       
    </div>



            

    <div class="container-PerfilAdm">
        <fieldset class="profile-Adm">
            <legend>Perfil</legend>
            <form action="../control/alteracaoAdm.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($id_usuario); ?>">
                <div class="fotoAdm-container">
                    <label for="foto" class="foto-label">
                        <img id="foto-preview" src="<?php echo htmlspecialchars($foto); ?>" >
                    </label>
                    <input type="file" name="foto" id="foto" accept="image/*" style="display: none;">
                </div>
                <label for="nome">Nome:</label>
                <input type="text" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required>
                <label for="email">E-mail:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                <input type="submit" value="Editar Informações">
            </form>
        </fieldset>
    </div>

    <script>
        const fotoInput = document.getElementById('foto');
        const fotoPreview = document.getElementById('foto-preview');

        fotoInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    fotoPreview.src = e.target.result; // Atualiza a imagem de pré-visualização
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>


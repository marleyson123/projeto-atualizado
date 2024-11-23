<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php"); // Redireciona para a página de login
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
    <link rel="stylesheet" href="../css/admGerencia.css">
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
        <a href="formMeuperfil.php" class="sidebar-btn">Meu Perfil</a>
        <a href="gerencia.php" class="sidebar-btn">Gerenciar Perfis</a>
        <a href="buscarPai.php" class="sidebar-btn">Cadastrar Alunos</a>
        <a href="formResponsavel.php" class="sidebar-btn">Cadastrar Responsável</a>
        <a href="professorForm.php" class="sidebar-btn">Cadastrar Professor</a>
        <a href="criarTurmas.php" class="sidebar-btn">Criar Turmas</a>
        <a href="turmas.php" class="sidebar-btn">Turmas</a>
    </div>

    <div class="content">
        <!-- Pesquisa -->
        <form action="" method="get" class="search-form">
            <input type="text" name="enviar" placeholder="Pesquisar" class="search-input">
            <input type="submit" value="Pesquisar" class="search-btn">
        </form>
         <?php
    require_once '../control/listarUsuarioControl.php';
    ?>
        <!-- Tabela de Usuários -->
       <div class="tabelas"> 
        <table class="table users-table">
        <h1 class="titulo">Professores e Responsavéis:</h1>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>CPF</th>
                <th>Perfil</th>
                <th colspan="2">Operações</th>
            </tr>
            <?php foreach ($usuarios as $t): ?>
                <tr>
                    <td><?php echo $t['id_usuario']; ?></td>
                    <td><?php echo $t['nome']; ?></td>
                    <td><?php echo $t['email']; ?></td>
                    <td><?php echo $t['cpf']; ?></td>
                    <td><?php echo $t['perfil']; ?></td>
                    <td>
                        <a href="../control/excluirUsuarioControl.php?id=<?php echo $t['id_usuario']; ?>">
                            <button class="btn btn-delete">Excluir</button>
                        </a>
                    </td>
                    <td>
                        <a href="../view/alterarUsuario.php?id=<?php echo $t['id_usuario']; ?>">
                            <button class="btn btn-edit">Alterar</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
                 <!-- Listar de Alunos -->
    <?php
    require_once '../control/listarAlunoControl.php';
    ?> 
        <!-- Tabela de Alunos -->
        <table class="table students-table">
        <h1 class="titulo">Alunos(a):</h1>
            <tr>
                <th>Matrícula</th>
                <th>Nome do Aluno(a)</th>
                <th>Data de Nascimento</th>
                <th>Tipo Sanguíneo</th>
                <th>Deficiência</th>
                <th>Alergia</th>
                <th>Nome do Responsável</th>
                <th>Operações</th>
            </tr>
            <?php foreach ($alunos as $t): ?>
                <tr>
                    <td><?php echo $t['matricula']; ?></td>
                    <td><?php echo $t['nome']; ?></td>
                    <td><?php echo $t['data_nascimento']; ?></td>
                    <td><?php echo $t['tipo_sanguineo']; ?></td>
                    <td><?php echo $t['deficiencia']; ?></td>
                    <td><?php echo $t['alergia']; ?></td>
                    <td><?php echo $t['nome_mae']; ?></td>
                    <td>
                        <a href="../view/alterarAluno.php?id=<?php echo $t['matricula']; ?>">
                            <button class="btn btn-edit">Alterar</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div> 
</body>

</html>

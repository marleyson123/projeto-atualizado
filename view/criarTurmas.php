<?php
session_start();
if (isset($_SESSION['id_usuario'])) {
    $idAdm = $_SESSION['id_usuario'];
    // Agora você pode usar $idAdm nesta página
} else {
    // Redirecionar para a página de login se a sessão não estiver definida
    header("Location: ../index.php");
    exit();
}
//   var_dump($idAdm);
?>

<?php
    require_once '../control/listarProfessores.php';
?>
<?php
    require_once '../control/listarTurmas.php';
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEMA | VM</title>
    <link rel="stylesheet" href="../css/admCriarTurmas.css">
</head>
<a href="../control/logout.php">Logout</a>
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
        <a href="formMeuperfil.php" class="sidebar-btn" onclick="showSection('perfil')">Meu Perfil</a>
        <a href="gerencia.php" class="sidebar-btn" onclick="showSection('gerencia')">Gerenciar Prefis</a>
        <a href="buscarPai.php " class="sidebar-btn" onclick="showSection('alunoForm')">Cadastrar Alunos</a>
        <a href="formResponsavel.php" class="sidebar-btn" onclick="showSection('responsavelForm')">Cadastrar Responsável</a>
        <a href="professorForm.php" class="sidebar-btn" onclick="showSection('professorForm')">Cadastrar Professor</a>
        <a href="criarTurmas.php" class="sidebar-btn" >Criar Turmas</a>
        <a href="turmas.php" class="sidebar-btn" >Turmas</a>


    </div>

    <div class="turmas">
                    
        <h1>Gerenciamento de Turmas</h1>

        <!-- Formulário para Criar Turma -->
        <h2>Criar Nova Turma</h2>
        <form action="../control/controleTurmas.php" method="POST">
            <label for="nome_turma">Nome da Turma:</label>
            <input type="text" name="nome_turma" required>

            <label for="ano">Ano:</label>
            <input type="number" name="ano" required>

            <label for="professor_responsavel">Professor Responsável:</label>
            <select name="professor_responsavel" required>
            <?php if (!empty($usuarios)): ?>
                <?php foreach ($usuarios as $t): ?>
                    <option value="<?php echo $t['id_professor']; ?>"><?php echo $t['nome']; ?></option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="">Nenhum professor encontrado</option>
            <?php endif; ?>
            </select>

            <!-- Campo oculto para o ID do administrador -->
            <input type="hidden" name="id_adm" value="<?php echo $idAdm; ?>">
            
            <input type="submit" name="criar_turma" value="Criar Turma">
        </form>

        <h2>Turmas Criadas</h2>

        <!-- Exibir as turmas criadas -->
        <table border="1">
            <thead>
                <tr>
                    <th>ID da Turma</th>
                    <th>Nome da Turma</th>
                    <th>Ano</th>
                    <th>Professor Responsável</th>
                    <th>Adicionar Alunos</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Mostrar as turmas existentes
                if (!empty($turmas)): 
                    foreach ($turmas as $turma): ?>
                        <tr>
                            <td><?php echo $turma['id_turma']; ?></td>
                            <td><?php echo $turma['nome_turma']; ?></td>
                            <td><?php echo $turma['ano']; ?></td>
                            <td><?php echo $turma['nome_professor']; ?></td>
                            <td>

                                <!-- Ao clicar, redireciona para a página de adicionar alunos -->
                                <a href="../view/adicionarAluno.php?id=<?php  echo $turma['id_turma']; ?>">
                                <button class="btn-adiciona">Adicionar Alunos</button>
                                </a>
                                
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Nenhuma turma encontrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    
</div>
</body>

</html>

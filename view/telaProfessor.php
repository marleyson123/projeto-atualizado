
<?php
require_once '../model/DAO/TurmaDAO.php';
require_once '../model/DAO/UsuarioDAO.php';
session_start();
// var_dump($_SESSION);

// Verifica se o professor está logado
if (!isset($_SESSION['id_usuario']) || $_SESSION['perfil'] !== 'professor') {
    echo "<script>alert('Acesso negado!'); window.location.href = '../index.php';</script>";
    exit;
}

$idUsuario = $_SESSION['id_usuario']; // ID do usuário logado

// Instancia o ProfessorDAO para buscar o ID do professor
$usuarioDAO = new UsuarioDAO();
$idProfessor = $usuarioDAO->buscarIdProfessorPorUsuario($idUsuario);

if (empty($idProfessor)) {
    echo "<script>alert('Nenhum professor encontrado para este usuário.'); window.location.href = '../index.php';</script>";
    exit;
}

$idProfessor = $idProfessor['id_professor']; // Extrai o ID do professor do resultado

// Instancia o TurmaDAO e busca as turmas do professor
$turmaDAO = new TurmaDAO();
$turmas = $turmaDAO->listarTurmasPorProfessor($idProfessor);

// echo"<pre>";
// var_dump($turmas);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turmas do Professor</title>
    <link rel="stylesheet" href="../css/telaProfessor.css">
</head>
<body>
    <!-- Barra de navegação -->
    <nav class="navbar">
        <div class="system-name">
            <h3>Educa<span>Mentes</span></h3>
        </div>
        <a href="../control/logout.php" class="logout-button">Sair</a>
    </nav>

    <h1>Turmas do Professor</h1>
    
    <?php if (!empty($turmas)): ?>
        <div class="turmas-container">
            <?php foreach ($turmas as $turma): ?>
                <!-- Exibe cada turma como um botão -->
                <a href="listarTurmasProfessor.php?id_turma=<?php echo htmlspecialchars($turma['id_turma']); ?>" 
                   class="turma-button">
                   <?php echo htmlspecialchars($turma['nome']); ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Nenhuma turma encontrada.</p>
    <?php endif; ?>
</body>
</html>

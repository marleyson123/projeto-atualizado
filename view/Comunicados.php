<?php
// Inicia a sessão
session_start();

// Verifica se o professor está logado
if (!isset($_SESSION['id_usuario']) || $_SESSION['perfil'] !== 'professor') {
    echo "<script>alert('Acesso negado!'); window.location.href = '../index.php';</script>";
    exit;
}

$idUsuario = $_SESSION['id_usuario']; // ID do usuário logado

// Instancia o ProfessorDAO para buscar o ID do professor
require_once '../model/DAO/UsuarioDAO.php';
$usuarioDAO = new UsuarioDAO();
$idProfessor = $usuarioDAO->buscarIdProfessorPorUsuario($idUsuario);

if (empty($idProfessor)) {
    echo "<script>alert('Nenhum professor encontrado para este usuário.'); window.location.href = '../index.php';</script>";
    exit;
}

$idProfessor = $idProfessor['id_professor']; // Extrai o ID do professor do resultado

// Verifica se o parâmetro 'matricula' foi passado na URL (matrícula do aluno)
if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];

    // Instancia o objeto AlunoDAO e tenta buscar o aluno pelo ID (matrícula)
    require_once '../model/DAO/AlunoDAO.php';
    $alunoDAO = new AlunoDAO();
    $aluno = $alunoDAO->buscarAlunoPorId($matricula);

    // Verifica se o aluno foi encontrado
    if (!$aluno) {
        echo "<p>Aluno não encontrado.</p>";
        exit;
    }

    // Você pode usar os dados do aluno aqui, por exemplo:
    // Exibir informações do aluno ou realizar outras ações conforme necessário
} else {
    echo "<p>Matrícula do aluno não informada.</p>";
    exit;
}


?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Aluno - EducaMentes</title>
    <link rel="stylesheet" href="../css/ajudar.css">
</head>
<body>
    <nav class="navbar">
        <div class="system-name">
            <h3>Comunicados:</h3>
        </div>
        <a href="../control/logout.php" class="logout-button">Sair</a>
    </nav>
    <br>
    <div class="menu_professor">
        <a href="perfilAluno.php?matricula=<?php echo htmlspecialchars($aluno['matricula']); ?>" class="sidebar-btn">Informações Pessoais</a>
        <a href="relatorio.php?matricula=<?php echo htmlspecialchars($aluno['matricula']); ?>" class="sidebar-btn">Relatórios</a>
        <a href="visualizarAtestados.php?matricula=<?php echo htmlspecialchars($aluno['matricula']); ?>" class="sidebar-btn">Visualizar atestados</a>
        <a href="listarTurmasProfessor.php?id_turma=<?php echo htmlspecialchars($aluno['id_turma']); ?>" class="sidebar-btn">Turma</a>
    </div>

    <div class="container">
        <div class="perfil-container">
            <h3>Enviar Mensagem para o Responsável</h3>
            
            <form action="../control/mensagemControl.php" method="POST">
                <!-- Campos ocultos -->
                <input type="hidden" name="id_responsavel" value="<?php echo htmlspecialchars($aluno['id_responsavel']); ?>">
                <input type="hidden" name="matricula" value="<?php echo htmlspecialchars($aluno['matricula']); ?>">
                <input type="hidden" name="id_turma" value="<?php echo htmlspecialchars($aluno['id_turma']); ?>">
                <input type="hidden" name="id_professor" value="<?php echo htmlspecialchars($idProfessor); ?>">

                <!-- Campo para escolher o tipo de mensagem -->
                <label for="tipo_mensagem">Tipo de Mensagem:</label>
                
                <select name="tipo_mensagem" id="tipo_mensagem">
                    <option value="Advertência">Advertência</option>
                    <option value="falta">Faltou à aula hoje!</option>
                    <option value="outros"></option>
                </select>
                    <br><br>
                <!-- Campo de mensagem -->
                <textarea name="mensagem" rows="4" placeholder="Digite sua mensagem..."></textarea>
                
                <button type="submit">Enviar</button>
            </form>


                <!-- Opções de Envio de Mensagem -->
                <div class="contact-options">
                    <h4>Ou entre em contato diretamente:</h4>
                    <a href="https://wa.me/<?php echo htmlspecialchars($responsavel['whatsapp']); ?>?text=Olá,%20preciso%20falar%20sobre%20o%20aluno%20<?php echo htmlspecialchars($aluno['nome']); ?>." target="_blank">
                    <button type="button">WhatsApp</button>
                    </a>
                    <a href="mailto:<?php echo htmlspecialchars($responsavel['email']); ?>?subject=Assunto%20relacionado%20ao%20aluno%20<?php echo htmlspecialchars($aluno['nome']); ?>&body=Olá,%20preciso%20falar%20sobre%20o%20aluno%20<?php echo htmlspecialchars($aluno['nome']); ?>." target="_blank">
                    <button type="button">E-mail</button>
                    </a>
                </div>
            </section>
        </div>
    </div>
</body>
</html>
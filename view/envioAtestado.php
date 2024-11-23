<?php

session_start();

// Verifica se o usuário está logado e tem o perfil 'responsavel'
if (!isset($_SESSION['id_usuario']) || $_SESSION['perfil'] !== 'responsavel') {
    echo "<script>alert('Acesso negado!'); window.location.href = '../index.php';</script>";
    exit;
}

require_once '../model/DAO/AlunoDAO.php';
// Verifica se a matrícula foi passada na URL
if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];
    
     // Instancia o objeto AlunoDAO e tenta buscar o aluno pelo ID (matrícula)
     $alunoDAO = new AlunoDAO();
     $aluno = $alunoDAO->buscarAlunoPorId($matricula);

    //  var_dump($aluno);
 
     require_once '../model/DAO/MensagemDAO.php';
     $mensagemDAO = new MensagemDAO();
 
     // Busca as mensagens do aluno
     $mensagens = $mensagemDAO->buscarMensagensPorAluno($matricula);

    //  var_dump($mensagens );

     if (!empty($mensagens)) {


                // Pegando o ID do professor a partir da primeira mensagem
        $idProfessor = $mensagens[0]['id_professor'];  // Supondo que todas as mensagens têm o mesmo professor

        // Buscando o id_usuario do professor
        require_once '../model/DAO/UsuarioDAO.php';
        $usuarioDAO = new UsuarioDAO();
        $professor = $usuarioDAO->buscarIdusuarioPorIdprofessor($idProfessor);

        // var_dump($professor);

        $usuarioDAO = new UsuarioDAO();
        $prof = $usuarioDAO->buscarUsuarioPorId($professor['usuario_id']);

        // var_dump($prof);
    } else {
        echo "<p>Não há mensagens para este aluno.</p>";
    }

    
    

    



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
        <h3>Anexar Atestados</h3> 
        </div>
        <a href="../control/logout.php" class="logout-button">Sair</a>
    </nav>
    <br>
    <div class="menu_professor">
        <a href="perfilAlunoPai.php?matricula=<?php echo htmlspecialchars($matricula); ?>" class="sidebar-btn">Informações Pessoais do Aluno(a)</a>
        <a href="avisos.php?matricula=<?php echo htmlspecialchars($aluno['matricula']); ?>" class="sidebar-btn">Avisos</a>
        <a href="visualizarRelatorio.php?matricula=<?php echo htmlspecialchars($matricula); ?>" class="sidebar-btn">Relatório do Aluno(a)</a>
    </div>

    <div class="container">
        <div class="perfil-container">
         
            <div>
            <h2>Envio de Atestado</h2>

            
            <form action="../control/processar_atestado.php" method="POST" enctype="multipart/form-data">
                <label for="imagem_atestado">Foto do Atestado:</label><br>
                <input type="file" id="imagem_atestado" name="imagem_atestado" accept="image/*" required><br><br>

                <!-- Campo oculto para o ID do aluno -->
                <input type="hidden" id="id_aluno" name="id_aluno" value="<?php echo htmlspecialchars($aluno['matricula']); ?>"><br>

                <!-- Campo oculto para o ID do responsável -->
                <input type="hidden" id="id_responsavel" name="id_responsavel" value="<?php echo htmlspecialchars($aluno['id_responsavel']); ?>"><br>

                <!-- Campo oculto para a data do atestado -->
                <input type="hidden" id="data_atestado" name="data_atestado" value="<?php echo date('Y-m-d'); ?>"><br>

                <button type="submit">Enviar Atestado</button>
            </form>
            </div>
        </div>
    </div>
</body>
</html>

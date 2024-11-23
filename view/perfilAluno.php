<?php
session_start();

// Verifica se o professor está logado
if (!isset($_SESSION['id_usuario']) || $_SESSION['perfil'] !== 'professor') {
    echo "<script>alert('Acesso negado!'); window.location.href = '../index.php';</script>";
    exit;
    
}
if (isset($_GET['matricula'])) {
    // Pega o valor da matrícula
    $matricula = $_GET['matricula'];
    // var_dump($matricula);

     // Instancia o objeto AlunoDAO e tenta buscar o aluno pela matrícula
     require_once '../model/DAO/AlunoDAO.php';
     $alunoDAO = new AlunoDAO();
     $aluno = $alunoDAO->buscarAlunoPorId($matricula);

    //  var_dump($aluno);
     

      // Busca os dados do responsável (mãe) com o id_responsavel
      require_once '../model/DAO/UsuarioDAO.php';
        $usuarioDAO = new UsuarioDAO();
        $responsavel = $usuarioDAO->buscarResponsavelPorId($aluno['id_responsavel']);

        $usuarioDAO = new UsuarioDAO();
        $res = $usuarioDAO->buscarUsuarioPorId($responsavel['usuario_id']);


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
            <h3>Perfil do aluno(a)</h3>
        </div>
        <a href="../control/logout.php" class="logout-button">Sair</a>
    </nav>
    <br>
    <div class="menu_professor">
       
        <a href="relatorio.php?matricula=<?php echo htmlspecialchars($aluno['matricula']); ?>" class="sidebar-btn">Relatórios</a>
        <a href="Comunicados.php?matricula=<?php echo htmlspecialchars($aluno['matricula']); ?>" class="sidebar-btn">Comunicados</a>
        <a href="visualizarAtestados.php?matricula=<?php echo htmlspecialchars($aluno['matricula']); ?>" class="sidebar-btn">Visualizar atestados</a>
        <a href="listarTurmasProfessor.php?id_turma=<?php echo htmlspecialchars($aluno['id_turma']); ?>" class="sidebar-btn">Turma</a>
    </div>

    <div class="container">
        <div class="perfil-container">
            <!-- Informações do Aluno -->
            <section class="perfil-aluno">
                <h2><?php echo htmlspecialchars($aluno['nome']); ?></h2>
                <div class="info-item">
                    <label for="matricula">Matrícula:</label>
                    <span id="matricula"><?php echo htmlspecialchars($aluno['matricula']); ?></span>
                </div>
                <div class="info-item">
                    <label for="ano_ingresso">Ano de Ingresso:</label>
                    <span id="ano_ingresso"><?php echo htmlspecialchars($aluno['ano_ingresso']); ?></span>
                </div>
                <div class="info-item">
                    <label for="data_nascimento">Data de Nascimento:</label>
                    <span id="data_nascimento"><?php echo htmlspecialchars($aluno['data_nascimento']); ?></span>
                </div>
                <div class="info-item">
                    <label for="tipo_sanguineo">Tipo Sanguíneo:</label>
                    <span id="tipo_sanguineo"><?php echo htmlspecialchars($aluno['tipo_sanguineo']); ?></span>
                </div>
                <div class="info-item">
                    <label for="deficiencia">Deficiência:</label>
                    <span id="deficiencia"><?php echo htmlspecialchars($aluno['deficiencia']); ?></span>
                </div>
                <div class="info-item">
                    <label for="alergia">Alergia:</label>
                    <span id="alergia"><?php echo htmlspecialchars($aluno['alergia']); ?></span>
                </div>
            </section>

            <!-- Informações da Mãe -->
            <section class="perfil-mae">
                <h2>Informações da Mãe</h2>
                <div class="info-item">
                    <label for="nome_mae">Nome:</label>
                    <span id="nome_mae"><?php echo htmlspecialchars($aluno['nome_mae']); ?></span>
                </div>
                <!-- Agora, estamos pegando os dados do responsável (mãe) -->
                <div class="info-item">
                    <label for="telefone_mae">Telefone:</label>
                    <span id="telefone_mae"><?php echo htmlspecialchars($responsavel['telefone']); ?></span>
                </div>
                <div class="info-item">
                    <label for="endereco_mae">Endereço:</label>
                    <span id="endereco_mae"><?php echo htmlspecialchars($responsavel['endereco']); ?></span>
                </div>
                <div class="info-item">
                    <label for="endereco_mae">E-mail:</label>
                    <span id="endereco_mae"><?php echo htmlspecialchars($res['email']); ?></span>
                </div>
            </section>

           
        </div>
    </div>
</body>
</html>
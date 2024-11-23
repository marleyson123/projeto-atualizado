<?php
    // Captura o ID da turma passado via URL
    if (isset($_GET['id'])) {
        $id_turma = $_GET['id'];
        //  var_dump($id_turma);
        
        // Exemplo: Use o ID da turma para fazer uma consulta no banco de dados e buscar os alunos e o professor da turma
        require '../model/DAO/TurmaDAO.php';
       
        $turmasDAO = new TurmaDAO();

        // Suponha que temos métodos para buscar alunos e professor pela turma
        $turmas = $turmasDAO->listarAlunosETurma($id_turma);

        // echo"<pre>";
        // var_dump($turmas);

           // Verifica se os dados da turma foram retornados
    if (!empty($turmas)) {
        // Definir os dados da turma e do professor a partir do primeiro aluno
        $nome_turma = $turmas[0]['nome_turma'];  // Nome da turma
        $nome_professor = $turmas[0]['nome_professor'];  // Nome do professor
    }
}

    
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Turma</title>
    <link rel="stylesheet" href="../css/admCriarTurmas.css">
</head>
<body>
    <?php if (!empty($turmas)): ?>
        <!-- Informações da turma e do professor -->
        <div class="turma-info">
            <h1>Turma: <?php echo htmlspecialchars($nome_turma); ?></h1>
            <h2>Professor: <?php echo htmlspecialchars($nome_professor); ?></h2>
        </div>

        <!-- Lista de alunos -->
        <h3>Alunos:</h3>
        <ul class="alunos-list">
            <?php foreach ($turmas as $turma): ?>
                <!-- Exibe os alunos -->
                <li><?php echo htmlspecialchars($turma['nome_aluno']); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Nenhum dado encontrado para a turma selecionada.</p>
    <?php endif; ?>
</body>
</html>
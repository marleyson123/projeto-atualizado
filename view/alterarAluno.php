<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php"); // Redireciona para a página de login
    exit;
}
?>

<?php

// pegar o id do usuario que sera alterado
require_once '../model/DTO/AlunoDTO.php';
require_once '../model/DAO/AlunoDAO.php';

$id = $_GET['id'];

// var_dump($id);

$alunoDAO = new AlunoDAO();
$aluno = $alunoDAO->BuscarAlunoPorId($id); // Busca os dados do aluno pelo ID

// echo"<pre>";
// var_dump($aluno); // Verifique o que está sendo retornado aqui

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEMA | VM</title>
    <link rel="stylesheet" href="../css/adm.css">
</head>

<body>
    <!-- Barra de navegação -->
    <nav class="navbar">
        <div class="system-name">
            <h3>Educa<span>Mentes</span></h3>
        </div>
        <a href="logout.php" class="logout-button">Sair</a>
    </nav>

    <div class="form-aluno">
       <fieldset class="fieldset-aluno">

            <h2>Formulário de Alteração: Aluno(a)</h2>
            
                <form action="../control/alterarAlunoControl.php" method="POST">
               
                <input type="hidden" name="matricula" value="<?php echo $aluno['matricula']; ?>">

                <p>Nome do responsável: <?php echo $aluno['nome_mae']; ?></p>


                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" placeholder="Nome do aluno(a)" value="<?php echo $aluno['nome']; ?>" required>
                
                <label for="ano_ingresso">Ano de Ingresso:</label>
                <input type="text" id="ano_ingresso" name="ano_ingresso" value="<?php echo $aluno['ano_ingresso']; ?>" required>
                   
                <label for="data_nascimento">Data de Nascimento:</label>
                <input type="date" id="data_nascimento" name="data_nascimento" value="<?php echo $aluno['data_nascimento']; ?>" required>
     
                <label for="tipo_sanguineo">Tipo Sanguíneo:</label>
                <select id="tipo_sanguineo" name="tipo_sanguineo" required>
                    <option value="">Selecione</option>
                    <option value="A+" <?php echo ($aluno['tipo_sanguineo'] == 'A+') ? 'selected' : ''; ?>>A+</option>
                    <option value="A-" <?php echo ($aluno['tipo_sanguineo'] == 'A-') ? 'selected' : ''; ?>>A-</option>
                    <option value="B+" <?php echo ($aluno['tipo_sanguineo'] == 'B+') ? 'selected' : ''; ?>>B+</option>
                    <option value="B-" <?php echo ($aluno['tipo_sanguineo'] == 'B-') ? 'selected' : ''; ?>>B-</option>
                    <option value="AB+" <?php echo ($aluno['tipo_sanguineo'] == 'AB+') ? 'selected' : ''; ?>>AB+</option>
                    <option value="AB-" <?php echo ($aluno['tipo_sanguineo'] == 'AB-') ? 'selected' : ''; ?>>AB-</option>
                    <option value="O+" <?php echo ($aluno['tipo_sanguineo'] == 'O+') ? 'selected' : ''; ?>>O+</option>
                    <option value="O-" <?php echo ($aluno['tipo_sanguineo'] == 'O-') ? 'selected' : ''; ?>>O-</option>
                </select>
        
                <label for="deficiencia">Deficiência:</label>
                <input type="text" id="deficiencia" name="deficiencia" placeholder="Descreva se houver" value="<?php echo $aluno['deficiencia']; ?>">
                <br>

                <label for="alergia">Alergia:</label>
                <input type="text" id="alergia" name="alergia" placeholder="Descreva se houver" value="<?php echo $aluno['alergia']; ?>">
                <br>

                <input type="submit" value="Alterar Informações">
            </form>
        </fieldset>
    </div>

</body>

</html>



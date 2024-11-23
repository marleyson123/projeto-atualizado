<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar Aluno</title>
</head>
<body>

<form method="POST" action="">
    <input type="text" name="search_id" placeholder="Pesquisar aluno por ID..." />
    <button type="submit" name="search">Pesquisar</button>
</form>

<?php
// Verifica se o formulário foi enviado
if (isset($_POST['search'])) {
    // Verifica se o campo 'search_id' foi preenchido
    $search_id = isset($_POST['search_id']) ? $_POST['search_id'] : '';  // Captura o ID do aluno inserido

    // Verifica se o campo de pesquisa não está vazio
    if (!empty($search_id)) {
        // Conexão com o banco de dados
        $conn = new mysqli('localhost', 'root', '', 'educamentes'); // Ajuste conforme seu banco

        // Verifica se a conexão foi bem-sucedida
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        // Consulta SQL para buscar aluno pelo ID
        $sql = "SELECT nome, matricula FROM aluno WHERE matricula = '$search_id'";  // Usando ID (matricula) para a busca
        $result = $conn->query($sql);

        // Verifica se encontrou algum aluno
        if ($result->num_rows > 0) {
            // Exibe os resultados
            echo "<h2>Resultado da Pesquisa:</h2>";
            while ($row = $result->fetch_assoc()) {

                // Captura o id_turma da URL
                $id_turma = isset($_GET['id']) ? $_GET['id'] : null;  // A partir da URL

                if ($id_turma) {
                    // Formulário para inserir dados na turma
                    echo '<form method="POST" action="../control/adicionarAlunoControl.php">';

                    // Adicionando o campo oculto para o ID da turma
                    echo '<input type="hidden" name="id_turma" value="' . $id_turma . '">';  // Passando o ID da turma
                    
                    // Passando a matrícula do aluno para o formulário
                    echo '<input type="hidden" name="matricula_aluno" value="' . $row['matricula'] . '">';
                    
                    // Campo para o nome do aluno
                    echo '<input type="text" name="nome_aluno" value="' . $row['nome'] . '" required>';
                    
                    // Campo para a data de inscrição
                    echo '<input type="date" name="data_inscricao" value="' . date('Y-m-d') . '" required>';
                    echo"<br> <br>";
                    
                    // Botão de inserção
                    echo '<button type="submit" name="inserir" value="inserir">Inserir</button>';
                    
                    // Fechando o formulário de inserção
                    echo '</form>';
                    
                    // Formulário para cancelar
                    echo"<br> <br>";
                    echo '<form method="POST" action="../view/criarTurmas.php">';
                    echo '<button type="submit" name="cancelar">Cancelar</button>';
                    echo '</form>';
                } else {
                    echo "ID da turma não encontrado.";
                }
            }
        } else {
            echo "Nenhum aluno encontrado com esse ID.";
        }

        // Fecha a conexão com o banco
        $conn->close();
    } else {
        echo "Por favor, insira um ID válido.";
    }
}
?>

</body>
</html>

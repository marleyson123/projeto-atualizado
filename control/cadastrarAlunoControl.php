<?php

require'../model/DTO/AlunoDTO.php';
require'../model/DAO/AlunoDAO.php';

// Iniciar a sessão para pegar o ID do administrador logado
session_start();

// Verificar se o administrador está logado e pegar o ID do administrador
if (isset($_SESSION['id_usuario'])) {
    $idAdm = $_SESSION['id_usuario'];  // O ID do administrador logado
} else {
    // Se o administrador não estiver logado, redirecionar para a página de login ou exibir erro
    echo "Você precisa estar logado como administrador para cadastrar um usuário.";
    exit(); // Encerra o script caso o administrador não esteja logado
}

 //alunoDTO
    // Captura os dados enviados pelo formulário
    $nome = $_POST['nome'];
    $ano_ingresso = $_POST['ano_ingresso'];
    $data_nascimento = $_POST['data_nascimento'];
    $tipo_sanguineo = $_POST['tipo_sanguineo'];
    $deficiencia = $_POST['deficiencia'];
    $alergia = $_POST['alergia'];
    $nome_mae = $_POST['nome_mae'];
    $id_responsavel = $_POST['id_responsavel'];

    // echo"<pre>";
    // var_dump($nome, $ano_ingresso, $data_nascimento,$tipo_sanguineo, $deficiencia, $alergia, $nome_mae, $id_responsavel);

      // Cria e configura o objeto DTO
      $alunoDTO = new AlunoDTO();
      $alunoDTO->setNome($nome);
      $alunoDTO->setAnoIngresso($ano_ingresso);
      $alunoDTO->setDataNascimento($data_nascimento);
      $alunoDTO->setTipoSanguineo($tipo_sanguineo);
      $alunoDTO->setDeficiencia($deficiencia);
      $alunoDTO->setAlergia($alergia);
      $alunoDTO->setNomeMae($nome_mae);
      $alunoDTO->setIdResponsavel($id_responsavel);
  
    //   echo"<pre><br>";
    //   var_dump($alunoDTO);
    $alunoDAO = new AlunoDAO();

    $resultado = $alunoDAO->cadastroAluno($alunoDTO, $idAdm);

        
 if ($resultado) {
    $mensagem = "Aluno(a) cadastrado com sucesso!";
    $status = "success";

  
} else {
    $mensagem = "Erro ao cadastrar Aluno(a)! .";
    $status = "error";
}

echo "<script type='text/javascript'>
        window.onload = function() {
            exibirModal('$mensagem', '$status');
        };
      </script>";

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado do Cadastro</title>
    <link rel="stylesheet" href="../css/cadastroUser.css">
</head>
<body>

<!-- Modal de feedback -->
<div id="modal" class="modal">
    <h1>Resultado do Cadastro</h1>
    <p id="mensagem"></p>
    <button onclick="fecharModal()">Fechar</button>
</div>

<!-- Importa o arquivo modal.js com o código JavaScript -->
<script src="../javaScript/cadastroUser.js"></script>

<!-- Script inline para exibir o modal ao carregar a página -->
<script type="text/javascript">
    window.onload = function() {
        exibirModal('<?php echo $mensagem; ?>', '<?php echo $status; ?>');
    };
</script> 
</body>
</html>

    







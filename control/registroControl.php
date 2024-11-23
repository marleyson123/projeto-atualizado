<?php
require_once "../model/DTO/RegistrosDTO.php";
require_once "../model/DAO/RegistrosDAO.php";
// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Pegar os dados enviados pelo formulário
    $documento = "";  // Nome do arquivo (documento)
    $tipo_documento = isset($_POST['tipo_arquivo']) ? $_POST['tipo_arquivo'] : '';  // Tipo de documento (relatório ou notas)
    $id_responsavel = isset($_POST['id_responsavel']) ? $_POST['id_responsavel'] : '';  // ID do responsável
    $id_aluno = isset($_POST['matricula']) ? $_POST['matricula'] : '';  // ID do aluno
    $datetime = date('Y-m-d H:i:s');  // Data e hora atual

    // Verifica se o arquivo PDF foi enviado
    if (isset($_FILES["arquivo_pdf"])) {
        if ($_FILES["arquivo_pdf"]["error"] === UPLOAD_ERR_OK) {
            // Recebe o nome do arquivo e cria um nome único
            $documento = $_FILES["arquivo_pdf"]["name"];
            $pastaDestino = "../uploads";
            $documento = uniqid() . "_" . $documento;  // Garantir que o nome do arquivo seja único
            $arqDestino = $pastaDestino . '/' . $documento;

            // Verifica se o diretório de destino existe e tem permissões corretas
            if (move_uploaded_file($_FILES["arquivo_pdf"]["tmp_name"], $arqDestino)) {
                echo "Arquivo carregado com sucesso!";
            } else {
                echo "Erro ao carregar o arquivo.";
            }
        } else {
            echo "Erro no upload do arquivo: " . $_FILES["arquivo_pdf"]["error"];
        }

        
    }
    $arquivo_pdf = $Arquivo;

    // Cria e configura o objeto DTO para registro
    $registroDTO = new RegistrosDTO();
    $registroDTO->setDocumento($documento);
    $registroDTO->setTipoDocumento($tipo_documento);
    $registroDTO->setIdAluno($id_aluno);
    $registroDTO->setIdResponsavel($id_responsavel);
    $registroDTO->setDatetime($datetime);

    var_dump($registroDTO);

    // // Exibir os dados do objeto DTO para depuração
    // echo "<pre>";
    // var_dump($registroDTO);
    // echo "</pre>";

    // // Inserindo o registro no banco de dados
    // $registroDAO = new RegistrosDAO();
    // $resultado = $registroDAO->inserirRegistro($registroDTO);

    // // Redireciona dependendo do sucesso ou falha
    // if ($resultado) {
    //     echo "<script>
    //         alert('Registro Enviado com Sucesso!');
    //         window.location.href = '../view/envioRegistro.php?matricula=" . urlencode($id_aluno) . "'; 
    //     </script>";
    // } else {
    //     echo "<script>
    //         alert('Falha ao enviar Registro, tente novamente!');
    //         window.location.href = '../view/envioRegistro.php?matricula=" . urlencode($id_aluno) . "'; 
    //     </script>";
    // }
}
?>


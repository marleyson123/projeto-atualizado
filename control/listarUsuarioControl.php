<?php


if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php"); // Redireciona para a página de login
    exit;
}

require_once '../model/DAO/UsuarioDAO.php';

// Verifica se o administrador está logado
if (isset($_SESSION['id_usuario'])) {
    $idAdm = $_SESSION['id_usuario']; // ID do administrador logado

    $usuarioDAO = new UsuarioDAO();
    $usuarios = $usuarioDAO->listarUsuarios(); // Lista os usuários associados ao administrador

    // Exibe os dados de $usuarios para depuração
    // echo"<pre>";
    // var_dump($usuarios);
}

?>

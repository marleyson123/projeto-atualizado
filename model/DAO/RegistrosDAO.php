<?php
require_once'Conexao.php';
require_once'../model/DTO/RegistroDTO.php';

class RegistrosDAO{
    public $pdo = null;
    //construtor da classe que estabelece a canexão com o banco de dados no momentoda criação do objeto DAO
    public function __construct(){
        $this->pdo = Conexao::getInstance();
    }



  



}
?>
























}
?>
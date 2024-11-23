<?php

class UsuarioDTO{
    private $id_usuario;
    private $nome;
    private $email;
    private $cpf;
    private $senha;
    private $perfil;

    public function setId_usuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }
  
    public function getId_usuario() {
        return $this->id_usuario;
    }
  
    public function setNome($nome) {
        $this->nome = $nome;
    }
  
    public function getNome() {
        return $this->nome;
    }

    public function setEmail($email) {
        $this->email = $email;
    }
  
    public function getEmail() {
        return $this->email;
    }
    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }
  
    public function getCpf() {
        return $this->cpf;
    }
    public function setSenha($senha) {
        $this->senha = $senha;
    }
  
    public function getSenha() {
        return $this->senha;
    }
    public function setPerfil($perfil) {
        $this->perfil = $perfil;
    }
  
    public function getPerfil() {
        return $this->perfil;
    }

    
}




?>
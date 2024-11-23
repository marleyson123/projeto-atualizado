<?php

require_once'Conexao.php';

class AdmDAO{
    //estabelecer conexão com o banco de dados
    public $pdo = null;
    //construtor da classe que estabelece a canexão com o banco de dados no momentoda criação do objeto DAO
    public function __construct(){
        $this->pdo = Conexao::getInstance();
    }

    public function validarLogin($email, $senha) {
        try {
            $sql = "SELECT * FROM cadastroadm WHERE email = :email AND senha = :senha;";
            $stml = $this->pdo->prepare($sql);
            $stml->bindParam(':email', $email);
            $stml->bindParam(':senha', $senha);
            $stml->execute();
    
            // Busca o resultado como um array associativo
            $retorno = $stml->fetch(PDO::FETCH_ASSOC);
    
            return $retorno;
        } catch(PDOException $exe) {
            echo $exe->getMessage();
        }
    }
    
    

    public function buscarDadosAdministrador($email) {
        
        $sql = "SELECT id_Adm, nome, email, foto FROM cadastroadm WHERE email = :email"; // Ajuste conforme sua tabela
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function atualizarAdministrador(AdmDTO $admDTO) {
        try {
            $query = "UPDATE cadastroadm SET nome = :nome, email = :email" . 
                     ($admDTO->getFoto() ? ", foto = :foto" : "") . 
                     " WHERE id_Adm = :id_Adm";
    
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':nome', $admDTO->getNome());
            $stmt->bindValue(':email', $admDTO->getEmail());
            $stmt->bindValue(':id_Adm', $admDTO->getIdAdm());
            
            // Bind the foto only if it's set
            if ($admDTO->getFoto()) {
                $stmt->bindValue(':foto', $admDTO->getFoto());
            }
    
            // Executa a consulta
            if (!$stmt->execute()) {
                // Se a execução falhar, obtenha os erros
                $errors = $stmt->errorInfo();
                error_log("Erro ao atualizar o administrador: " . implode(", ", $errors));
                return false;
            }
    
            return true; // Retorna true se a atualização for bem-sucedida
        } catch (PDOException $e) {
            // Captura qualquer exceção do PDO e registra o erro
            error_log("Erro PDO ao atualizar administrador: " . $e->getMessage());
            return false;
        }
    }
    


    

   
    
    
    






















    }
  









   
    




?>
<?php
declare(strict_types=1);
namespace App\Classes;

use PDOException;
use Exception;
use PDO;

class Pessoa
{
    private $pdo;

    //construtor instanciando PDO por composição
    public function __construct($dbname, $host, $user, $senha){
        try{
            $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host, $user, $senha);
        } catch (PDOException $e){
            echo "Erro DB: ".$e->getMessage();
            exit();
        } catch (Exception $e){
            echo "Erro genérico: ".$e->getMessage();
            exit();
        }
    }

    //método que cadastra pessoa
    public function cadastrarPessoa($nome, $email, $senha){
        $cmd = $this->pdo->prepare("SELECT id FROM usuarios WHERE email = :e");
        $cmd->bindValue(":e", $email);
        $cmd->execute();
        if($cmd->rowCount() > 0){
            return false;
        } else{
            $cmd = $this->pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (:n, :e, :s)");
            $cmd->bindValue(":n", $nome);
            $cmd->bindValue(":e", $email);
            $cmd->bindValue(":s", $senha);
            $cmd->execute();
            return true;
        }
    }

    //método que exclui uma pessoa do db
    public function excluirPessoa($id){
        $cmd = $this->pdo->prepare("DELETE FROM usuarios WHERE id = :i");
        $cmd->bindValue(":i", $id);
        $cmd->execute();
    }

    //método que busca todos os dados do db
    public function buscarDados(){
        $resultado = [];
        $cmd = $this->pdo->query("SELECT * FROM usuarios ORDER BY id DESC");
        $resultado = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
}
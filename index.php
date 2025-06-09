<?php
    declare(strict_types=1);
    require("vendor/autoload.php");
    use App\Classes\Pessoa;

    $pessoa = new Pessoa("crudpdo", "localhost", "root", "");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título, Ícone, Descrição e Cor de tema p/ navegador -->
    <title>CRUD PDO OO</title>
    <link rel="icon" type="image/x-icon" href="">
    <meta name="description" content="">
    <meta name="theme-color" content="#FFFFFF">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Fontawesome JS -->
    <script src="https://kit.fontawesome.com/6afdaad939.js" crossorigin="anonymous">      </script>
    <!-- Folha CSS-->
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <?php 
    if(isset($_POST['submit'])){
        $nome = htmlspecialchars($_POST['nome']);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $senha = htmlspecialchars($_POST['senha']);

        if($pessoa->cadastrarPessoa($nome, $email, $senha)){
            echo "Cadastrado com sucesso!";
        }else{
            echo "E-mail já cadastrado";
        }
    }


    ?>
    
    <div class="container my-5">
        <div class="row d-flex justify-content-around">
            <div class="col-11 col-md-4 p-4 border">
                <form method="POST">
                    <h2 class="mb-3">Cadastrar pessoa</h2>
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input required class="form-control" type="text" name="nome" placeholder="Insira um nome">
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input required class="form-control" type="email" name="email" placeholder="Insira um e-mail">
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input required class="form-control" type="password" name="senha">
                    </div>
                    <button class="btn btn-primary w-100" type="submit" name="submit">Cadastrar</button>
                </form>
            </div>
            <div class="col-11 col-md-6 p-4 text-center border">
                <h2 class="mb-3">Pessoas cadastradas</h2>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $dados = $pessoa->buscarDados();
                            if(empty($dados)){
                                echo "<tr>";
                                echo "<th colspan=\"4\">Nenhuma pessoa cadastrada</th>";
                                echo "</tr>";
                            } else {
                                foreach($dados as $dado){
                                    echo "<tr>";
                                    echo "<td>".$dado['nome']."</td>";
                                    echo "<td>".$dado['email']."</td>";
                                    echo "<td> <a href=''>Editar</a> <a href='index.php?id=".$dado['id']."'>Excluir</a>";
                                    echo "</tr>";
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>

<?php 
    if(isset($_GET['id'])){
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if($pessoa->excluirPessoa($id)){
            echo "Pessoa excluída com sucesso";
        } else {
            echo "Erro ao excluir pessoa";
        }

        header("Location: index.php");
    } 

?>
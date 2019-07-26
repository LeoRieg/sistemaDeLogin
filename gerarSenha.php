<?php
require_once 'configDb.php';#para usar o banco de dados
$msg = "";
if(isset($_GET['email']) && isset($_GET['token'])){
    $email = $_GET['email'];
    $token = $_GET['token'];
    
    $sql = $conexão->prepare("SElECT * FROM usuario WHERE"
            . "email=? and token=? AND "
            . "tokenExpirado > now()");
    $sql->bind_param("ss", $email, $token);
    $sql->execute();
    $resultado = $sql->get_result();
    
    if(isset($_POST['gerar'])){#botao cadastrar senha
        $novaSenha = sha1 ($_POST['senha']);
        $confirmarSenha = sha1 ($_POST['csenha']);
        if($novaSenha == $confirmarSenha){
            $sql = $conexão->prepare("UPDATE usuario"
                    . "SET token=?'', senha=? WHERE"
                    . "email=?");
            $sql->bind_param("ss",$novaSenha,$email);
            $sql->execute();
            $msg = "<em class='text-sucess'>"
                    . "Senha alterada com sucesso</em>";
        }else{
            $msg = "<em class='text-danger'>"
                    . "Senhas não conferem</em>";
        }
    }
    
    if($resultado->num_rows > 0){
        
    }else{
        header("location:index.php");#email ou token inválidos
        exit();
    }
        
    }else{#digitou a página do email sem token
    header("location:index.php");
    exit();
    }

?>


<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Gerar uma nova senha</title>
  </head>
  <body>
      <main class="container">
          <section class="row justify-content-center"> 
              <div class="col-lg-5 mt-5">
                  <h3 class="text-center bg-dark text-light p-2 rounded">
                      Gere uma nova senha
                  </h3>
                  <h4 class="bg-info text-center">
                      <?= @$msg ?>
                  </h4>
                  
                  <form method="post" action="#">
                      <!-- envio para a própria páginass -->
                      <div class="form-group">
                          <label for="senha">Nova Senha</label>
                          <input type="password" name="senha" id="senha"
                                 class="form-control" placeholder="Nova Senha"
                                 required>
                              
                      </div>
                      <div class="form-group">
                          <label for="csenha">Confirmar senha</label>
                          <input type="password" name="senha" id="csenha"
                                 class="form-control" placeholder="Confirmar Senha"
                                 required>
                      </div>
                      <div class="form-group">
                          <input type="submit" value="Cadastrar senha"
                                 class="btn btn-block btn-primary"
                                 name="gerar">
                          
                      </div>
                      
                  </form>
                  
              </div>
              
          </section>
          
      </main> 
      
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
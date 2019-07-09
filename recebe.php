<?php

//deportando configurações de banco de dados

require_once 'configDB.php';

//limpando os dados de entrada post
function verificar_entrada($entrada) {
    $saída = trim($entrada); //remove espaços
    $saída = htmlspecialchars($saída); //remove html
    $saída = stripcslashes($saída); //remove barras        
    return $saída;
}

if (isset($_POST['action']) && $_POST ['action'] == 'registro') {
    echo "oi";
    $nomeCompleto = verificar_entrada($_POST ['nomeCompleto']);
    $nomeUsuário = verificar_entrada($_POST ['nomeUsuario']);
    $emailUsuário = verificar_entrada($_POST['emailUsuario']);
    $senhaUsuário = verificar_entrada($_POST['senhaUsuario']);
    $senhaUsuarioConfirmar = verificar_entrada($_POST["senhaUsuarioConfirmar"]);
    $criado = date('Y-m-d'); //cria uma data ANO-Mes-Dia
    //echo "Hash: " . $senha;
    //gerar um hash ára as senhas
    $senha = shal($senhaUsuário);
    $senhaConfirmar = shal($senhaUsuarioConfirmar);

    if ($senha != $senhaConfirmar) {
        echo 'as senhas não conferem';
        exit();
    } else {
        $sql = $conexão->prepare("SELECT nomeUsuario, email FROM "
                . "usuario WHERE nomeUSuario = ? OR email = ?");
        $sql = bind_param("ss", $nomeUsuário, $emailUsuário);
        $sql = execute();
        $linha = $resultado->fetch_array(MYSQL_ASSOC);
        if ($linha['nomeUsuario'] == $nomeUsuário)
            echo "Nome {$nomeUsuário} indisponivel.";
        else if ($linha[email] == $emailUsuário)
            echo "E-mail {$emailUsuário} indisponivel.";
        else {
            $sql = $conexão->prepare("INSERT INTO usuario "
                    . "(nome, nomeUsuario, email, senha, criado)"
                    . "VALUES(?,?,?,?,?)");
            $sql->bind_param("sssss", $nomeCompleto, $nomeUsuário, $emailUsuário, $senha, $criado);
        }

        if ($sql->execute()) {
            echo "Cadastrado com sucesso!";
        } else {
            echo "Algo deu errado. Por favor tente novamente";
        }
    }
}


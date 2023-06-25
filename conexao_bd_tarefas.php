<?php
    $servidor = "localhost";
    $bd = "lista_de_tarefas";
    $usuario = "root";
    $senha = "";

    $conexao = new mysqli($servidor, $usuario, $senha, $bd);

    //Tratamento para verificar a conexão
    if($conexao->connect_errno){
        echo "Falha ao conectar: " . $conexao->connect_errno;
    }else{
        //echo "Conectado com sucesso!";
    }
?>
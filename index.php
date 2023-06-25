<?php
    include("conexao_bd_tarefas.php");

    //Verifica se está recebendo o valor do campo
    if(isset($_POST['submit'])){
        
        //Armazena os dados digitados nas variáveis
        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];
        // $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
        // $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
        
        //POST
        $query = "INSERT INTO `tarefas`(`id`, `titulo`, `descricao`, `data_criacao`, `data_conclusao`) VALUES ('','$titulo','$descricao',now(),'')";
        $stm = $conexao->prepare($query);
        $stm->execute();

        header('Location: http://192.168.15.9/projeto_lista_de_tarefas/');//redireciona para a index, limpando o formulário
    }

    //SELECT
    $query = "SELECT * FROM tarefas";
    $todas_tarefas = $conexao->query($query)->fetch_all(MYSQLI_ASSOC);//busca todas as tarefas e o MYSQLI_ASSOC faz com que seja associado o índice ao nome das colunas.

    // var_dump($todas_tarefas);

    //UPDATE
    if(isset($_GET['concluir'])){
        $id = $_GET['concluir'];
        $query = "UPDATE `tarefas` SET `data_conclusao`= now() WHERE id=$id";
        $stm = $conexao->prepare($query);
        $stm->execute();

        header('Location: http://192.168.15.9/projeto_lista_de_tarefas/');
    }

    //DELETE
    if(isset($_GET['excluir'])){
        $id = $_GET['excluir'];
        $query = "DELETE FROM `tarefas` WHERE id=$id";
        $stm = $conexao->prepare($query);
        $stm->execute();

        header('Location: http://192.168.15.9/projeto_lista_de_tarefas/');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <title>Lista de Tarefas</title>
</head>
<body>
    <div class="container_tarefas">
        <div class="content_tarefas">
            <h1>Lista de Tarefas</h1>
            <form method="post">
                <h2>Adicionar nova tarefa</h2>

                <label for="titulo">Título</label>
                <input id="titulo" type="text" name="titulo" placeholder="Digite o título da tarefa"/>

                <label for="descricao">Descrição</label>
                <input id="descricao" type="text" name="descricao" placeholder="Digite a descrição da tarefa"/>

                <input type="submit" name="submit" value="Adicionar"/>
            </form>

            <div class="listagem_tarefas">
                <ul>
                    <?php foreach($todas_tarefas as $item){?>
                        <li>
                            <h3><?=$item['titulo']?></h3>
                            <p><?=$item['descricao']?></p>

                            <div class="btns_tarefas">
                                <?php if($item['data_conclusao'] == '0000-00-00 00:00:00'){?>
                                    <a href="?concluir=<?= $item['id']?>">Feito</a>
                                <?php }; ?>
                                <a href="?excluir=<?= $item['id']?>">Excluir</a>
                            </div>
                        </li>
                    <?php };?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
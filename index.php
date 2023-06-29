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

    $todas_tarefas_reverse = array_reverse($todas_tarefas);
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
    <link type="text/css" href="estilo.css" rel="stylesheet" >
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&family=Open+Sans:wght@300;600&display=swap" rel="stylesheet">
    <title>Lista de Tarefas</title>
</head>
<body>
    <div class="container_tarefas">
        <div class="header_tarefas">
            <img src="./images/logo_tarefas.png"/>
            <h1>Lista de Tarefas</h1>
        </div>
        <div class="content_tarefas">
            <div class="add_view_tarefas">
                <form method="post">
                    
                    <div class="inputs_tarefas titulo_tarefas">
                        <label for="titulo">Título</label>
                        <input id="titulo" type="text" name="titulo" placeholder="Digite o título da tarefa"/>
                    </div>
                    
                    <div class="inputs_tarefas desc_tarefas">
                        <label for="descricao">Descrição</label>
                        <textarea id="descricao" type="text" name="descricao" placeholder="Digite a descrição da tarefa"></textarea>
                    </div>                

                    <input class="btn_add_tarefas" type="submit" name="submit" value="Adicionar"/>
                </form>

                <div class="listagem_tarefas">
                    <ul>
                        <?php foreach($todas_tarefas_reverse as $item){?>
                            <li>
                                <div class="infos_tarefa">
                                    <div>
                                        <h3><?=$item['titulo']?></h3>
                                        <p><?=$item['descricao']?></p>
                                    </div>
                                    <div>
                                        <span><b>criação:</b> <?=$item['data_criacao']?></span>
                                        <?php if($item['data_conclusao'] !== '0000-00-00 00:00:00'){?>
                                        <span><b>conclusão:</b> <?=$item['data_conclusao']?></span>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="btns_tarefas">
                                    
                                    <a href="?excluir=<?= $item['id']?>" class="btn_acao">
                                        <img src="./images/delete_tarefas.png" />
                                        Excluir
                                    </a>

                                    <?php if($item['data_conclusao'] == '0000-00-00 00:00:00'){?>
                                        <a href="?concluir=<?= $item['id']?>" class="btn_acao">
                                            <img src="./images/check_tarefas.png" />
                                            Feito
                                        </a>
                                    <?php }; ?>
                                </div>
                            </li>
                        <?php };?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
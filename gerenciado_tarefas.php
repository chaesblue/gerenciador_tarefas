<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <form method="POST" s>
        <label for="novaTarefa">Adicionar nova tarefa:</label><br>
        <input type="text" name="novaTarefa" id="novaTarefa">
        <button type="submit">Adicionar</button>
    </form>


    <?php
        //estudar como exibir lista completa e n só o ultimo item adicionado
        session_start();

        if (!isset($_SESSION["tarefas"])) {
            $_SESSION["tarefas"] =[
                ["nome" => "Estudar PHP", "concluida" => false],
                ["nome" => "Praticar lógica de programação", "concluida" => false],
                ["nome" => "Fazer exercícios de arrays", "concluida" => false],
            ];
        }

        
        
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["novaTarefa"])) {
        $novaTarefa = trim($_POST["novaTarefa"]);

            if (empty($novaTarefa)) {
        echo " Você precisa digitar uma tarefa.<br>";
    } elseif (strlen($novaTarefa) < 3) {
        echo " A tarefa deve ter pelo menos 3 caracteres.<br>";
    } else {
        

        $_SESSION["tarefas"][] = ["nome" => htmlspecialchars($novaTarefa), "concluida" => false];
        echo "Tarefa adicionada com sucesso!<br>";
    }
        }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["apagar"])) {
    $indiceTarefa = $_POST["indiceTarefa"];
    
    // Remover a tarefa usando o índice
    array_splice($_SESSION["tarefas"], $indiceTarefa, 1);
    echo "Tarefa apagada com sucesso!<br>";
    }

        echo "<h3>Lista de Tarefas:</h3>";

    foreach ($_SESSION["tarefas"] as $indice => $tarefa) {
        $status = $tarefa["concluida"] ? "[Concluída] " : "";
        echo $indice . " - " . $status . $tarefa["nome"] . "";

        //apaga tarefas
         echo '<form method="POST" style="display:inline;">
            <input type="hidden" name="indiceTarefa" value="' . $indice . '">
            <button type="submit" name="apagar">Apagar</button>
          </form>';
    
        echo "<br>";
    }


    
    ?>


    
</body>
</html>




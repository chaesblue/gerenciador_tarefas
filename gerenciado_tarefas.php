<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>Gerenciador de Tarefas</title>
</head>

<body>

<div class="conteudo_principal">
    <div class="php">

        <?php
            session_start();


            if (!isset($_SESSION["tarefas"])) {
                $_SESSION["tarefas"] = [
                    ["nome" => "Estudar PHP", "concluida" => false],
                    ["nome" => "Praticar lógica de programação", "concluida" => false],
                    ["nome" => "Fazer exercícios de arrays", "concluida" => false],
                ];
            }


            if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["novaTarefa"])) {
                $novaTarefa = trim($_POST["novaTarefa"]);

                if (empty($novaTarefa)) {
                    echo "Você precisa digitar uma tarefa.<br>";
                } elseif (strlen($novaTarefa) < 3) {
                    echo "A tarefa deve ter pelo menos 3 caracteres.<br>";
                } else {
                    $_SESSION["tarefas"][] = ["nome" => htmlspecialchars($novaTarefa), "concluida" => false];
                }
            }


            if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["apagar"])) {
                $indiceTarefa = $_POST["indiceTarefa"];
                array_splice($_SESSION["tarefas"], $indiceTarefa, 1);

                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }


            if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["concluir"])) {
                $indiceTarefa = $_POST["indiceTarefa"];
                if (isset($_SESSION["tarefas"][$indiceTarefa])) {
                    $_SESSION["tarefas"][$indiceTarefa]["concluida"] = true;
                }

                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }


            echo "<h3>Lista de Tarefas:</h3>";

            foreach ($_SESSION["tarefas"] as $indice => $tarefa) {
            
                if (!$tarefa["concluida"]) {
                    echo '<form method="POST" style="display:inline; margin-right:5px;">
                            <input type="hidden" name="indiceTarefa" value="' . $indice . '">
                            <button type="submit" name="concluir" id="button_concluir">
                                <i class="bi bi-check-circle-fill"></i>
                            </button>
                        </form>';
                }

                
                $status = $tarefa["concluida"] ? "<span style='color:green;'>[Concluída]</span> " : "<span style='color:red;'>[Pendente]</span>";
                echo $indice . " - " . $status . htmlspecialchars($tarefa["nome"]);

                echo '<form method="POST" style="display:inline;">
                        <input type="hidden" name="indiceTarefa" value="' . $indice . '">
                        <button type="submit" id="button_apagar" name="apagar"><i class="bi bi-trash"></i></button>
                    </form>';


                echo "<br>";
            }
        ?>

    </div>
        <div class="forms">
            <form method="POST" s>
                <label for="novaTarefa">Gerenciador de <br> tarefas</label><br>
                <input type="text" name="novaTarefa" placeholder="Inserir nova tarefa :" id="novaTarefa"><br>
                <button id="buttonInserir" type="submit">Adicionar</button>
            </form>
        </div>
    </div>

</body>
</html>

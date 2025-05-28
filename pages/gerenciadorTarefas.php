<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zentask - Gerenciador Tarefas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    
    <style>
        #register-form {
            box-shadow: 0 0 10px 1px black;
            border-radius: 10px;
            position: absolute;
            top: 60%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 500px;
            height: 90%;
            padding: 20px 20px;
            display: flex;
            flex-direction: column;
        }

        #register-form input {
            margin-top: 50px;
            height: 40px;
            border-radius: 9px;
            padding: 5px 15px;
            outline: none;
            border: none;
            border: 1px solid black;
        }

        #register-form select {
            margin-top: 50px;
            height: 40px;
            border-radius: 9px;
            padding: 5px 15px;
            outline: none;
            border: none;
            border: 1px solid black;
        }

        #register-form textarea {
            margin-top: 50px;
            padding: 10px 10px;
            outline: none;
            border-radius: 9px;
        }

        .title-form {
            text-align: center;
            /* text-transform: uppercase; */
            font-family: 'Poppins', sans-serif;
            letter-spacing: 2px;
            font-weight: 300;
        }


        .button-form-register {
            margin: 0 auto;
            margin-top: 45px;
            width: 240px;
            height: 5vh;
            border: none;
            outline: none;
            border-radius: 10px;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .button-form-register:hover {
            background-color: #0056b3;
            color: #fff;
        }
    </style>

    </head>
  <body>

    <!-- Barra de navegação -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary barraNavegacao">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Zentask</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="cadastrarUser.php">Cadastro Usuário</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cadastrarTarefa.php">Cadastro Tarefa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gerenciadorTarefas.php">Gerenciador Tarefas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <?php
            require_once "conexaoGenTarefa.php";

            $sql = "SELECT nomeTarefa, descricaoTarefa, nomeSetor, statusTarefa, dataTarefa, prioridadeTarefa FROM tarefa ORDER BY id_tarefa DESC";
            $sqluser = "SELECT nome  FROM usuario";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dados as $dado) {

                // Div geral da tarefa
                echo "<div class='box-tarefa'>";

                echo "<h1>" . $dado['statusTarefa'] . "</h1>";

                // Essa div  mostra as informações da tarefa
                echo "<div class='box-info-tarefa'>";

                echo "<p><strong>Nome Tarefa:</strong>" . htmlspecialchars($dado['nomeTarefa']) . ";" ."</p>";
                echo "<p><strong>Descrição:</strong> " . htmlspecialchars($dado['descricaoTarefa']) . ";" ."</p>";
                echo "<p><strong>Setor:</strong> " . htmlspecialchars($dado['nomeSetor']) . ";" ."</p>";
                echo "<p><strong>Data:</strong> " . htmlspecialchars($dado['dataTarefa']) . ";" ."</p>";
                echo "<p><strong>Prioridade:</strong> " . htmlspecialchars($dado['prioridadeTarefa']) . "</p>";

                // Essa div é a finalização da div infos
                echo "</div>";

                // Essa div mostra as opções de ação presentes na tarefa
                echo "<div class='box-tarefa-ferramentas'>";
                echo "<button 
                type='button' 
                class='btn btn-primary' 
                data-bs-toggle='modal' 
                data-bs-target='#exampleModal'
                >
                Editar</button>";


                echo "<button type='button' class='btn btn-danger'>Excluir</button>";

                // Essa div é a finalização da box-tarefa-ferramentas
                echo "</div>";

                // Essa div é a finalizaçãp da box-tarefa
                echo "</div>";

                // Sereve para dar um "espaço" para as divs de cada tarefa
                echo "<br>";
            }
            ?>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Editar</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form action="" method="POST">
                                <div class="mb-3">
                                    <input type="text" name="nomeTarefa" class="form-control" id="exampleFormControlInput1"
                                        placeholder="Digite o nome da tarefa">
                                </div>

                                <div class="mb-3">
                                <input type="hidden" name="idTarefa" class="form-control" id="exampleFormControlInput1"
                                        placeholder="Digite a numeração da tarefa">
                                </div>

                                <!-- Input de setor -->
                                <div class="mb-3">
                                    <input type="text" name="setorTarefa" class="form-control" id="exampleFormControlInput1"
                                        placeholder="Setor da tarefa">
                                </div>

                                <!-- Input de setor -->
                                <div class="mb-3">
                                    <input type="date" name="dataTarefa" class="form-control" id="exampleFormControlInput1">
                                </div>

                                <!-- Editar descrição da tarefa -->
                                <div class="mb-3">
                                    <textarea class="form-control" name="descricaoTarefa" id="exampleFormControlTextarea1" rows="3"
                                    placeholder="Digite a descrição da sua tarefa"></textarea>
                                </div>

                                <!-- Seleção para colocar a opção de status da tarefa -->
                                <select class="form-select" name="statusTarefa" aria-label="Default select example">
                                    <option selected disabled>Selecione o status</option>
                                    <option value="A fazer">A fazer</option>
                                    <option value="Fazendo">Fazendo</option>
                                    <option value="Pronto">Pronto</option>
                                </select> <br>

                                <!-- Seleção para colocar a opção de prioridade da tarefa -->
                                <select class="form-select"  name="prioridadeTarefa" aria-label="Default select example">
                                    <option selected disabled>Selecione a prioridade</option>
                                    <option value="Baixa">Baixa</option>
                                    <option value="Media">Média</option>
                                    <option value="Alta">Alta</option>
                                </select>

                                <!-- Button para enviar o form de edição da tarefa -->

                                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  </body>
</html>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        require_once 'conexaoGenTarefa.php';

        $idTarefa = $_POST['idTarefa'];
        $nomeTarefa = $_POST['nomeTarefa'];
        $descricaoTarefa = $_POST['descricaoTarefa'] ?? '';
        $setorTarefa = $_POST['setorTarefa'] ?? '';
        $dataTarefa = $_POST['dataTarefa'] ?? '';
        $statusTarefa = $_POST['statusTarefa'] ?? '';
        $prioridadeTarefa = $_POST['prioridadeTarefa'] ?? '';


        $sql = "UPDATE tarefa SET nomeTarefa = :nomeTarefa, descricaoTarefa = :descricaoTarefa, nomeSetor = :nomeSetor, dataTarefa = :dataTarefa, statusTarefa = :statusTarefa, prioridadeTarefa = :prioridadeTarefa WHERE id_tarefa = :id_tarefa";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(":nomeTarefa", $nomeTarefa);
        $stmt->bindParam(":descricaoTarefa", $descricaoTarefa);
        $stmt->bindParam(":nomeSetor", $setorTarefa);
        $stmt->bindParam(":dataTarefa", $dataTarefa);
        $stmt->bindParam(":statusTarefa", $statusTarefa);
        $stmt->bindParam(":prioridadeTarefa", $prioridadeTarefa);
        $stmt->bindParam(":id_tarefa", $idTarefa);



        if($stmt->execute()) {
            echo "<script>alert('Tarefa editada com sucesso!')</script>";
        } else {
            echo "<script>alert('Desculpe, não foi possivel atualizar a tarefa!')</script>";
        }
          
    }              
?>
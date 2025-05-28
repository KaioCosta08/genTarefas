<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zentask - Register Tarefa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .legend-form {
            text-align: center;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.9rem;
            letter-spacing: 3px;
        }

        #form-registe-user {
            box-shadow: 0 0 10px 3px black;
            position: absolute;
            top: 57%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 550px;
            height: 85vh;
            padding: 10px 20px;
            border-radius: 10px;
        }

        .btn-register-form {
            display: block;
            margin: 0 auto;
            margin-top: 40px;
            width: 200px;
            height: 7vh;
            border: none;
            border-radius: 10px;
            font-size: 1.3rem;
            transition: 1s;
        }

        .btn-register-form:hover {
            background-color: blue;
            color: #fff;
            transition: 1s;
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
                        <a class="nav-link" href="#">Gerenciador Tarefas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Formulário para cadastrar o usuário -->
    <form action="" method="POST" id="form-registe-user">
        <legend class="legend-form">Cadastre Tarefa</legend>
        <!-- Input de nome -->
        <div class="mb-3">
            <input type="text" name="nomeTarefa" class="form-control" id="exampleFormControlInput1"
                placeholder="Digite sua tarefa">
        </div>
        <!-- Input de email -->
        <div class="mb-3">
            <input type="text" name="setorTarefa" class="form-control" id="exampleFormControlInput1"
                placeholder="Setor da tarefa">
        </div>
        <div class="mb-3">
            <textarea class="form-control" name="descricaoTarefa" id="exampleFormControlTextarea1" rows="3"
                placeholder="Digite a descrição da sua tarefa"></textarea>
        </div>
        <div class="mb-3">
            <input type="date" name="dataTarefa" class="form-control" id="exampleFormControlInput1">
        </div>
        <select class="form-select" aria-label="Default select example">
            <option selected disabled>Selecione o usuário</option>
            <?php

            require_once '../conexaoGenTarefa.php';

            $sql = "SELECT nome FROM usuario";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($usuarios as $usuario) {
                echo "<option value='{$usuario['nome']}'> {$usuario['nome']} </option> ";
            }

            ?>
        </select>

        <!-- Seleção para colocar a opção de status da tarefa -->
        <select class="form-select" name="statusTarefa" aria-label="Default select example">
            <option selected disabled>Selecione o status</option>
            <option value="afazer">A fazer</option>
            <option value="fazendo">Fazendo</option>
            <option value="pronto">Pronto</option>
        </select>

        <!-- Seleção para colocar a opção de prioridade da tarefa -->
        <select class="form-select"  name="prioridadeTarefa" aria-label="Default select example">
            <option selected disabled>Selecione a prioridade</option>
            <option value="baixa">Baixa</option>
            <option value="media">Média</option>
            <option value="alta">Alta</option>
        </select>

        <!-- Button para enviar o formulário -->
        <button type="submit" class="btn-register-form">Cadastrar Tarefa</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>
</body>

</html>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../conexaoGenTarefa.php';

    $descricaoTarefa = $_POST['descricaoTarefa'] ?? '';
    $setorTarefa = $_POST['setorTarefa'] ?? '';
    $dataTarefa = $_POST['dataTarefa'] ?? '';
    $statusTarefa = $_POST['statusTarefa'] ?? '';
    $prioridadeTarefa = $_POST['prioridadeTarefa'] ?? '';

    
    $sql = "INSERT INTO tarefa(descricaoTarefa, nomeSetor, dataCadastrado, statusTarefa, prioridadeTarefa) VALUES (:descricaoTarefa, :nomeSetor, :dataCadastrado, :statu, :prioridade)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":descricaoTarefa", $descricaoTarefa);
    $stmt->bindParam(":nomeSetor", $setorTarefa);
    $stmt->bindParam(":dataCadastrado", $dataTarefa);
    $stmt->bindParam(":statu", $statusTarefa);
    $stmt->bindParam(":prioridade", $prioridadeTarefa);

    if($stmt->execute()) {
        echo "<script>alert('Tarefa cadastrada com sucesso!')</script>";
    } else {
        echo "<script>alert('Desculpe, essa tarefa não foi cadastrada!')";
    }
}

?>
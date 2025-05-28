<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zentask - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    <style>

        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .legend-form{
            text-align: center;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.9rem;
            letter-spacing: 3px;
        }

        #form-registe-user {
            box-shadow: 0 0 10px 3px black;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 550px;
            height: 40vh;
            padding: 10px 20px;
            border-radius: 10px;
        }

        .btn-register-form{
            display: block;
            margin: 0 auto;
            width: 200px;
            height: 7vh;
            border: none;
            border-radius: 10px;
            font-size: 1.3rem;
            transition: 1s;
        }

        .btn-register-form:hover{
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
        <legend class="legend-form">Cadastre-se!</legend>
        <!-- Input de nome -->
        <div class="mb-3">
            <input type="text" name="nomeUsuario" class="form-control" id="exampleFormControlInput1" placeholder="Digite seu nome">
        </div>
        <!-- Input de email -->
        <div class="mb-3">
            <input type="email" name="emailUsuario" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
        </div>

        <!-- Button para enviar o formulário -->
         <button type="submit" class="btn-register-form">Cadastrar</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>
</body>

</html>

<!-- PHP levando os dados do cadastro de usuários para o banco de dados -->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../conexaoGenTarefa.php';

    $nome = $_POST['nomeUsuario'] ?? '';
    $email = $_POST['emailUsuario'] ?? '';

    $sql = "INSERT INTO usuario(nome, email) VALUES (:nome, :email)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":email", $email);

    if ($stmt->execute()) {
        echo "<script>alert('Dados cadastrados com sucesso!')</script>";
    } else {
        echo "<script>alert('Ocorreu um erro no envio dos dados')</script>";
    }
}
?>
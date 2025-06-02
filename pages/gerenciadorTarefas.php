<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zentask - Gerenciador Tarefas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .box-tarefa {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .box-info-tarefa p {
            margin: 5px 0;
        }

        .box-tarefa-ferramentas {
            width: 200px;
            margin-top: 15px;
            display: flex;
            gap: 25px;
        }
    </style>
</head>
<body>

<!-- Navegação padrão -->
<nav class="navbar navbar-expand-lg bg-body-tertiary barraNavegacao">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Zentask</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link active" href="cadastrarUser.php">Cadastro Usuário</a></li>
                <li class="nav-item"><a class="nav-link" href="cadastrarTarefa.php">Cadastro Tarefa</a></li>
                <li class="nav-item"><a class="nav-link" href="gerenciadorTarefas.php">Gerenciador Tarefas</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container mt-4">
<?php
require_once "conexaoGenTarefa.php";

// $sql = "SELECT id_tarefa, nomeTarefa, descricaoTarefa, nomeSetor, statusTarefa, dataTarefa, prioridadeTarefa FROM tarefa ORDER BY id_tarefa DESC";
$sql = "SELECT 
    tarefa.id_tarefa, 
    tarefa.nomeTarefa,
    tarefa.descricaoTarefa,
    tarefa.nomeSetor,
    tarefa.dataTarefa,
    usuario.nome,
    tarefa.statusTarefa,
    tarefa.prioridadeTarefa,
    tarefa.id_usuario
    FROM 
    tarefa
    JOIN 
    usuario 
    ON 
    tarefa.id_usuario = usuario.id_usuario;";
$stmt = $conn->prepare($sql);
$stmt->execute();
$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if(isset($_POST['id_tarefa'])) {
        $id = intval($_POST['id_tarefa']);

        $sql = "DELETE FROM tarefa  WHERE id_tarefa = :id_tarefa";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_tarefa', $id, PDO::PARAM_INT);

        if($stmt->execute()) {
            echo '<script>alert("Essa tarefa foi apagada com sucesso!"); window.location.href = "gerenciadorTarefas.php"</script>';
        } else {
            echo '<script>alert("Erro ao apagar a tarefa.")</script>';
        }
    }
}


foreach ($dados as $dado) {
    echo "<div class='box-tarefa'>";
    echo "<h1>{$dado['statusTarefa']}</h1>";
    echo "<h4>Numeração da Tarefa: {$dado['id_tarefa']}</h4>";

    echo "<div class='box-info-tarefa'>";
    echo "<p><strong>Nome Tarefa:</strong> " . htmlspecialchars($dado['nomeTarefa']) . "</p>";
    echo "<p><strong>Descrição:</strong> " . htmlspecialchars($dado['descricaoTarefa']) . "</p>";
    echo "<p><strong>Setor:</strong> " . htmlspecialchars($dado['nomeSetor']) . "</p>";
    echo "<p><strong>Data:</strong> " . htmlspecialchars($dado['dataTarefa']) . "</p>";
    echo "<p><strong>Nome do usuário:</strong> " . htmlspecialchars($dado['nome']) . "</p>";
    echo "<p><strong>Prioridade:</strong> " . htmlspecialchars($dado['prioridadeTarefa']) . "</p>";
    echo "</div>";

    echo "<div class='box-tarefa-ferramentas'>";

    // MODIFICAÇÃO 1: Adicionamos atributos data-* no botão "Editar"
    // Motivo: Esses dados serão usados via JavaScript para preencher o modal dinamicamente com os dados da tarefa selecionada.
    echo "<button 
        type='button' 
        class='btn btn-primary btn-editar' 
        data-bs-toggle='modal' 
        data-bs-target='#exampleModal'
        data-id='{$dado['id_tarefa']}'
        data-nome='" . htmlspecialchars($dado['nomeTarefa']) . "'
        data-descricao='" . htmlspecialchars($dado['descricaoTarefa']) . "'
        data-setor='" . htmlspecialchars($dado['nomeSetor']) . "'
        data-data='{$dado['dataTarefa']}'
        data-id_usuario='{$dado['id_usuario']}'
        data-status='{$dado['statusTarefa']}'
        data-prioridade='{$dado['prioridadeTarefa']}'
    >Editar</button>";

    echo "<form method='POST' onsubmit='confirm(\"Quer mesmo excluir essa tarefa?\");'>";
    echo "<input type='hidden' name='id_tarefa' value='{$dado['id_tarefa']}'>";
    echo "<button type='submit' class='btn btn-danger'>Excluir</button>";

    echo "</form>";

    echo "</div></div>";
}
?>
</main>

<!-- MODIFICAÇÃO 2: Criamos um único modal fora do loop -->
<!-- Motivo: Reutilizamos o mesmo modal para todas as tarefas, preenchendo dinamicamente com JS. Evita repetição e melhora desempenho. -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Editar Tarefa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <!-- MODIFICAÇÃO 3: Campo hidden para ID da tarefa -->
                    <!-- Motivo: Enviar o ID da tarefa para o PHP via POST sem mostrar ao usuário -->
                    <input type="hidden" name="idTarefa" id="inputIdTarefa">

                    <!-- Demais campos com IDs únicos para serem acessados pelo JS -->
                    <div class="mb-3">
                        <input type="text" name="nomeTarefa" id="inputNomeTarefa" class="form-control" placeholder="Nome da tarefa">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="setorTarefa" id="inputSetorTarefa" class="form-control" placeholder="Setor da tarefa">
                    </div>
                    <div class="mb-3">
                        <input type="date" name="dataTarefa" id="inputDataTarefa" class="form-control">
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" name="descricaoTarefa" id="inputDescricaoTarefa" rows="3" placeholder="Descrição da tarefa"></textarea>
                    </div>
                    
                    <select id="inputUsuario" class="form-select" name="id_usuario" aria-label="Default select example">
                    <option selected disabled>Selecione o usuário</option>
                    <?php

                    require_once 'conexaoGenTarefa.php';

                    $sql = "SELECT id_usuario, nome FROM usuario";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($usuarios as $usuario) {
                        echo "<option value='{$usuario['id_usuario']}'> {$usuario['nome']} </option> ";
                    }

                    ?>
                    </select><br>

                    <select class="form-select" name="statusTarefa" id="inputStatusTarefa">
                        <option disabled selected>Selecione o status</option>
                        <option value="A fazer">A fazer</option>
                        <option value="Fazendo">Fazendo</option>
                        <option value="Pronto">Pronto</option>
                    </select><br>
                    <select class="form-select" name="prioridadeTarefa" id="inputPrioridadeTarefa">
                        <option disabled selected>Selecione a prioridade</option>
                        <option value="Baixa">Baixa</option>
                        <option value="Media">Média</option>
                        <option value="Alta">Alta</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODIFICAÇÃO 4: Script para preencher o modal com os dados da tarefa clicada -->
<!-- Motivo: Quando o usuário clica em "Editar", o JavaScript preenche o formulário do modal com os dados corretos -->
<script>
document.querySelectorAll('.btn-editar').forEach(button => {
    button.addEventListener('click', () => {
        document.getElementById('inputIdTarefa').value = button.dataset.id;
        document.getElementById('inputNomeTarefa').value = button.dataset.nome;
        document.getElementById('inputSetorTarefa').value = button.dataset.setor;
        document.getElementById('inputDataTarefa').value = button.dataset.data;
        document.getElementById('inputDescricaoTarefa').value = button.dataset.descricao;
        document.getElementById('inputUsuario').value = button.dataset.id_usuario;  
        document.getElementById('inputStatusTarefa').value = button.dataset.status;
        document.getElementById('inputPrioridadeTarefa').value = button.dataset.prioridade;
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// MODIFICAÇÃO 5: Lógica de atualização via POST movida para o final do arquivo
// Motivo: Permite tratar o envio do formulário e atualizar a tarefa no banco após clique em "Salvar Alterações"
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'conexaoGenTarefa.php';

    $idTarefa = $_POST['idTarefa'] ?? '';
    $nomeTarefa = $_POST['nomeTarefa'] ?? '';
    $descricaoTarefa = $_POST['descricaoTarefa'] ?? '';
    $setorTarefa = $_POST['setorTarefa'] ?? '';
    $dataTarefa = $_POST['dataTarefa'] ?? '';
    $statusTarefa = $_POST['statusTarefa'] ?? '';
    $prioridadeTarefa = $_POST['prioridadeTarefa'] ?? '';
    $idUsuario = $_POST['id_usuario'] ?? '';

    $sql = "UPDATE tarefa SET nomeTarefa = :nomeTarefa, descricaoTarefa = :descricaoTarefa, nomeSetor = :nomeSetor, dataTarefa = :dataTarefa, id_usuario = :id_usuario ,statusTarefa = :statusTarefa, prioridadeTarefa = :prioridadeTarefa WHERE id_tarefa = :id_tarefa";
    $stmt1 = $conn->prepare($sql);

    $stmt1->bindParam(":id_tarefa", $idTarefa);
    $stmt1->bindParam(":nomeTarefa", $nomeTarefa);
    $stmt1->bindParam(":descricaoTarefa", $descricaoTarefa);
    $stmt1->bindParam(":nomeSetor", $setorTarefa);
    $stmt1->bindParam(":dataTarefa", $dataTarefa);
    $stmt1->bindParam(":id_usuario", $idUsuario);
    $stmt1->bindParam(":statusTarefa", $statusTarefa);
    $stmt1->bindParam(":prioridadeTarefa", $prioridadeTarefa);

    if ($stmt1->execute()) {
        echo "<script>alert('Tarefa editada com sucesso!'); window.location.href = 'gerenciadorTarefas.php';</script>";
    } else {
        echo "<script>alert('Erro ao editar tarefa.');</script>";
    }
}
?>

<?php


?>
<?php
$host = 'localhost';
$db = 'gerenciadorTarefas';
$user = 'root';
$pass = '';

try{
    $conn = new PDO("mysql:host=$host;dbname=$db;charset-utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "<script>confirm('Conexão realizado com sucesso!')</script>";
}catch(PDOException $e){
    // echo "<script>confirm('Erro de conexão com o banco de dados!')</script>";
}
?>
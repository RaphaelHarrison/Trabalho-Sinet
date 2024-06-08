<?php
session_start();
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $cep = $_POST['cep'];
    $endereco = $_POST['endereco'];

    $sql = "UPDATE usuarios SET email='$email', cpf='$cpf', cep='$cep', endereco='$endereco' WHERE id='$user_id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("success" => false, "error" => $conn->error));
    }

    $conn->close();
} else {
    echo json_encode(array("success" => false, "error" => "Método inválido"));
}
?>
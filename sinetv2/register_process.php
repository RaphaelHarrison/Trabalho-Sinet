<?php
session_start();
include 'conexao.php';

$email = $_POST['email'];
$cpf = $_POST['cpf'];
$senha = $_POST['senha'];
$cep = $_POST['cep'];
$endereco = $_POST['endereco'];

$message = "";

// Verificar se todos os campos foram preenchidos
if (empty($email) || empty($cpf) || empty($senha) || empty($cep) || empty($endereco) ) {
    $message = "Todos os campos são obrigatórios!";
}  else {
    // Criptografar a senha antes de armazená-la no banco de dados
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Verifica se o email já está registrado
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $message = "Email já registrado!";
    } else {
        $sql = "INSERT INTO users (email, cpf, senha, cep, endereco) VALUES ('$email', '$cpf', '$senha_hash', '$cep', '$endereco')";
        if ($conn->query($sql) === TRUE) {
            $message = "Registro feito com sucesso!";
        } else {
            $message = "Erro: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();

// Redireciona para a página principal com a mensagem como parâmetro
header("Location: index_logado.html?message=" . urlencode($message));
exit();
?>

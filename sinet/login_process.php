<?php
session_start();
include 'conexao.php';

if (isset($_POST['email']) && isset($_POST['senha'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $message = "";

    // Verificar se todos os campos foram preenchidos
    if (empty($email) || empty($senha)) {
        $message = "Todos os campos são obrigatórios!";
    } else {
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Compare a senha fornecida com a senha no banco de dados usando password_verify
            if (password_verify($senha, $row['senha'])) {
                $message = "Login bem-sucedido!";
                // Define um cookie contendo o ID do usuário válido por 30 dias
                setcookie('user_id', $row['id'], time() + (86400 * 30), "/");
                header("Location: index_logado.html?message=" . urlencode($message));
                exit();
                // Você pode adicionar variáveis de sessão para manter o usuário logado
                $_SESSION['user_id'] = $row['id']; // Exemplo de armazenamento do ID do usuário na sessão
                $_SESSION['email'] = $row['email'];
            } else {
                $message = "Senha incorreta!";
                header("Location: loginregistro.html?message=" . urlencode($message));
            }
        } else {
            $message = "Usuário não encontrado!";
        }
    }

    $conn->close();
} else {
    $message = "Todos os campos são obrigatórios!";
}

// Redireciona para a página principal com a mensagem como parâmetro
?>
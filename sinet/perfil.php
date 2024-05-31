<?php
// Incluir o arquivo de conexão com o banco de dados
include 'conexao.php';

// Iniciar a sessão
session_start();

// Verificar se o cookie 'user_id' está presente
if(isset($_COOKIE['user_id'])) {
    // Recuperar o ID do usuário a partir do cookie
    $user_id = $_COOKIE['user_id'];

    // Buscar informações do usuário no banco de dados usando o ID recuperado do cookie
    $sql = "SELECT * FROM usuarios.users WHERE id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Obter os dados do perfil do usuário
        $row = $result->fetch_assoc();
        $perfil = array(
            'email' => $row['email'],
            'cpf' => $row['cpf'],
            'cep' => $row['cep'],
            'endereco' => $row['endereco']
        );

        // Retorna os dados do perfil como JSON
        echo json_encode($perfil);
    } else {
        echo "Usuário não encontrado.";
    }
} else {
    // Se o cookie não estiver presente, redirecionar o usuário para a página de login
    header("Location: login.html");
    exit();
}

$conn->close();
?>
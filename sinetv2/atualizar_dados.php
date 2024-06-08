<?php
// Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se os dados foram enviados via JSON
    $data = json_decode(file_get_contents("php://input"), true);

    // Verifica se o ID da conta foi recebido
    if (isset($data['user_id'])) {
        $account_id = $data['user_id'];

        // Conecta ao banco de dados
        $servername = "localhost";
        $username = "root";
        $password = "3601";
        $dbname = "usuarios";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verifica a conexão
        if ($conn->connect_error) {
            die(json_encode(["success" => false, "message" => "Falha na conexão com o banco de dados."]));
        }

        // Obtém os dados a serem atualizados
        $email = $conn->real_escape_string($data['email']);
        $cpf = $conn->real_escape_string($data['cpf']);
        $cep = $conn->real_escape_string($data['cep']);
        $endereco = $conn->real_escape_string($data['endereco']);

        // Atualiza os dados no banco de dados
        $sql = "UPDATE usuarios.users SET email='$email', cpf='$cpf', cep='$cep', endereco='$endereco' WHERE id='$account_id'";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(["success" => true, "message" => "Dados atualizados com sucesso."]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao atualizar os dados: " . $conn->error]);
        }

        $conn->close();
    } else {
        echo json_encode(["success" => false, "message" => "ID da conta não encontrado."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método de requisição não suportado."]);
}
?>
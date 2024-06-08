document.addEventListener("DOMContentLoaded", function() {
    // Função para buscar as informações do perfil do usuário
    function buscarInformacoesPerfil() {
        // Faz uma requisição AJAX para buscar as informações do perfil do usuário
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "perfil.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Se a requisição for bem-sucedida, exibe as informações do perfil na página
                var perfil = JSON.parse(xhr.responseText);
                document.getElementById("email").textContent = perfil.email;
                document.getElementById("cpf").textContent = perfil.cpf;
                document.getElementById("cep").textContent = perfil.cep;
                document.getElementById("endereco").textContent = perfil.endereco;
            }
        };
        xhr.send();
    }

    // Chama a função para buscar as informações do perfil quando a página é carregada
    buscarInformacoesPerfil();
});
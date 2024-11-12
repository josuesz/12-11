<?php
// Configurações de conexão com o banco de dados
$servername = "localhost"; // Host do MySQL (normalmente "localhost" para o XAMPP ou WAMP)
$username = "root";        // Nome de usuário do MySQL (usuário padrão é "root" no XAMPP/WAMP)
$password = "";            // Senha do MySQL (geralmente em branco no XAMPP/WAMP)
$database = "empresa";     // Nome do banco de dados que você criou

// Criação da conexão
$conn = new mysqli($servername, $username, $password, $database);

// Verificação se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Se a conexão foi bem-sucedida, pode-se usar a variável $conn para fazer consultas ao banco
?>

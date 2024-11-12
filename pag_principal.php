<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal com Menus</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .menu {
            background-color: #333;
            overflow: hidden;
        }
        .menu a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .menu a:hover {
            background-color: #575757;
            color: white;
        }
        .container {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="menu">
        <?php
        // Configuração da conexão com o banco de dados
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "empresa";

        // Criar conexão
        $conn = new mysqli($servername, $username, $password, $database);

        // Verificar se há erro na conexão
        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }

        // Consulta para buscar os nomes dos funcionários e seus cargos
        $sql = "SELECT fun_nome, fun_cargo FROM tbl_funcionario";
        $result = $conn->query($sql);

        // Gerar o menu com os dados dos funcionários, se existirem
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Exibir os nomes e cargos dos funcionários como itens do menu
                echo '<a href="#">' . htmlspecialchars($row["fun_nome"]) . ' (' . htmlspecialchars($row["fun_cargo"]) . ')</a>';
            }
        } else {
            echo '<a href="#">Nenhum Funcionário Cadastrado</a>';
        }
        ?>
    </div>

    <div class="container">
        <h1>Página Principal</h1>
        <p>Bem-vindo à página principal. Utilize o menu acima para navegar.</p>

        <h2>Registros Cadastrados</h2>
        <?php
        // Consulta para buscar os registros de presença (tbl_registros)
        $sql_registros = "SELECT r.reg_data, r.reg_hora, f.fun_nome, f.fun_cargo 
                          FROM tbl_registros r 
                          JOIN tbl_funcionario f ON r.fun_codigo = f.fun_codigo";
        $result_registros = $conn->query($sql_registros);

        // Exibir os registros cadastrados, se existirem
        if ($result_registros->num_rows > 0) {
            echo '<table border="1" cellpadding="10" cellspacing="0">';
            echo '<tr><th>Data</th><th>Hora</th><th>Funcionário</th><th>Cargo</th></tr>';
            while ($row = $result_registros->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row["reg_data"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["reg_hora"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["fun_nome"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["fun_cargo"]) . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo "<p>Nenhum registro encontrado.</p>";
        }

        // Fechar a conexão com o banco de dados
        $conn->close();
        ?>
    </div>
</body>
</html>

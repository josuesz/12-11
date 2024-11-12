<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Funcionário</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Estilo Global */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            text-align: center;
            color: #333;
        }

        form {
            margin-bottom: 30px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
            color: #555;
        }

        input[type="text"], input[type="submit"] {
            padding: 12px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .message {
            text-align: center;
            font-weight: bold;
            margin-top: 15px;
        }

        .message.success {
            color: green;
        }

        .message.error {
            color: red;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f7fc;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        a {
            color: #007BFF;
            text-decoration: none;
            font-size: 14px;
        }

        a:hover {
            text-decoration: underline;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .actions a {
            padding: 5px 10px;
            background-color: #f2f2f2;
            border-radius: 5px;
            border: 1px solid #ddd;
            transition: background-color 0.3s;
        }

        .actions a:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cadastro de Funcionário</h1>

        <!-- Formulário de Cadastro de Funcionário -->
        <form action="" method="post">
            <label for="fun_nome">Nome do Funcionário:</label>
            <input type="text" id="fun_nome" name="fun_nome" required>

            <label for="fun_cargo">Cargo:</label>
            <input type="text" id="fun_cargo" name="fun_cargo" required>

            <input type="submit" name="submit" value="Cadastrar">
        </form>

        <?php
        // Conexão com o banco de dados
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "empresa";

        $conn = new mysqli($servername, $username, $password, $database);

        // Verificar conexão
        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }

        // Se o formulário de cadastro for enviado
        if (isset($_POST['submit'])) {
            $fun_nome = $_POST['fun_nome'];
            $fun_cargo = $_POST['fun_cargo'];

            // Inserir o novo funcionário no banco de dados
            $sql = "INSERT INTO tbl_funcionario (fun_nome, fun_cargo) VALUES ('$fun_nome', '$fun_cargo')";

            if ($conn->query($sql) === TRUE) {
                echo "<div class='message success'>Funcionário cadastrado com sucesso!</div>";
            } else {
                echo "<div class='message error'>Erro ao cadastrar: " . $conn->error . "</div>";
            }
        }

        // Se a ação for para alterar o funcionário
        if (isset($_GET['alterar'])) {
            $fun_codigo = $_GET['alterar'];
            // Consultar os dados do funcionário
            $sql = "SELECT * FROM tbl_funcionario WHERE fun_codigo = $fun_codigo";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $fun_nome = $row['fun_nome'];
                $fun_cargo = $row['fun_cargo'];
                ?>
                <!-- Formulário de Alteração -->
                <h2>Alterar Funcionário</h2>
                <form action="" method="post">
                    <input type="hidden" name="fun_codigo" value="<?php echo $fun_codigo; ?>">
                    <label for="fun_nome">Nome:</label>
                    <input type="text" id="fun_nome" name="fun_nome" value="<?php echo $fun_nome; ?>" required>

                    <label for="fun_cargo">Cargo:</label>
                    <input type="text" id="fun_cargo" name="fun_cargo" value="<?php echo $fun_cargo; ?>" required>

                    <input type="submit" name="alterar_submit" value="Alterar Funcionário">
                </form>
                <?php
            }
        }

        // Se a ação for para excluir o funcionário
        if (isset($_GET['excluir'])) {
            $fun_codigo = $_GET['excluir'];

            // Excluir o funcionário
            $sql = "DELETE FROM tbl_funcionario WHERE fun_codigo = $fun_codigo";

            if ($conn->query($sql) === TRUE) {
                echo "<div class='message success'>Funcionário excluído com sucesso!</div>";
            } else {
                echo "<div class='message error'>Erro ao excluir: " . $conn->error . "</div>";
            }
        }

        // Se o formulário de alteração for enviado
        if (isset($_POST['alterar_submit'])) {
            $fun_codigo = $_POST['fun_codigo'];
            $fun_nome = $_POST['fun_nome'];
            $fun_cargo = $_POST['fun_cargo'];

            // Atualizar o funcionário no banco de dados
            $sql = "UPDATE tbl_funcionario SET fun_nome = '$fun_nome', fun_cargo = '$fun_cargo' WHERE fun_codigo = $fun_codigo";

            if ($conn->query($sql) === TRUE) {
                echo "<div class='message success'>Funcionário alterado com sucesso!</div>";
            } else {
                echo "<div class='message error'>Erro ao alterar: " . $conn->error . "</div>";
            }
        }

        // Listar todos os funcionários cadastrados
        $sql = "SELECT * FROM tbl_funcionario";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "<h2>Funcionários Cadastrados</h2>";
            echo "<table>
                    <tr>
                        <th>Nome</th>
                        <th>Cargo</th>
                        <th>Ações</th>
                    </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['fun_nome'] . "</td>
                        <td>" . $row['fun_cargo'] . "</td>
                        <td class='actions'>
                            <a href='?alterar=" . $row['fun_codigo'] . "'>Alterar</a> | 
                            <a href='?excluir=" . $row['fun_codigo'] . "' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>
                        </td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Nenhum funcionário cadastrado.</p>";
        }

        // Fechar a conexão
        $conn->close();
        ?>
    </div>
</body>
</html>

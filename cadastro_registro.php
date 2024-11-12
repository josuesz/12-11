<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 100%;
            max-width: 500px;
            margin: 50px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 10px 0 5px;
            color: #555;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"],
        input[type="time"],
        input[type="submit"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            border: none;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        input[type="number"]:focus,
        input[type="time"]:focus {
            border-color: #4CAF50;
            outline: none;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.4);
        }

        .message {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }

        .message.success {
            color: green;
        }

        .message.error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cadastro de Registro</h1>
        <form action="" method="post">
            <label for="reg_data">Data:</label>
            <input type="date" id="reg_data" name="reg_data" required>
            
            <label for="reg_hora">Hora:</label>
            <input type="time" id="reg_hora" name="reg_hora" required>

            <label for="fun_codigo">Código do Funcionário:</label>
            <input type="number" id="fun_codigo" name="fun_codigo" required>

            <input type="submit" name="submit" value="Cadastrar">
        </form>

        <?php
        if (isset($_POST['submit'])) {
            // Conexão com o banco de dados
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "empresa";

            $conn = new mysqli($servername, $username, $password, $database);

            if ($conn->connect_error) {
                die("Falha na conexão: " . $conn->connect_error);
            }

            // Sanitização e validação das entradas
            $reg_data = isset($_POST['reg_data']) ? $_POST['reg_data'] : '';
            $reg_hora = isset($_POST['reg_hora']) ? $_POST['reg_hora'] : '';
            $fun_codigo = isset($_POST['fun_codigo']) ? $_POST['fun_codigo'] : '';

            if ($reg_data && $reg_hora && $fun_codigo) {
                // Preparando a consulta para evitar SQL Injection
                $stmt = $conn->prepare("INSERT INTO tbl_registros (reg_data, reg_hora, fun_codigo) VALUES (?, ?, ?)");
                $stmt->bind_param("ssi", $reg_data, $reg_hora, $fun_codigo);

                if ($stmt->execute()) {
                    echo "<div class='message success'>Registro cadastrado com sucesso!</div>";
                } else {
                    echo "<div class='message error'>Erro ao cadastrar: " . $stmt->error . "</div>";
                }

                $stmt->close();
            } else {
                echo "<div class='message error'>Preencha todos os campos corretamente.</div>";
            }

            $conn->close();
        }
        ?>
    </div>
</body>
</html>


<?php
include('../../security_access/conexao.php');

if(isset($_POST['username']) || isset($_POST['password'])) {
    if(strlen($_POST['username']) == 0) {
        echo "<script>alert(\"Preencha seu nome de usuario\")</script>";
    } else if (strlen($_POST['password']) == 0){
        echo "<script>alert(\"Preencha sua senha\")</script>";;
    } else {
        $username = $mysqli->real_escape_string($_POST['username']);
        $password = $mysqli->real_escape_string($_POST['password']);

        $sql_code = "SELECT * FROM usuarios WHERE username = '$username' AND senha = '$password'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        $quantidade = $sql_query->num_rows;

        if($quantidade == 1) {

            $usuario = $sql_query->fetch_assoc();

            if(!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $usuario['ID_Usuario'];
            $_SESSION['foto'] = $usuario['Foto_perfil'];
            $_SESSION['username'] = $usuario['Username'];
            $_SESSION['nome'] = $usuario['Nome'];

            header("Location: ../../");
        } else {
            echo "<script>alert(\"Falha ao logar! Usuário ou senha incorretos\")</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoSphere | Login</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #121212; /* Fundo escuro */
            color: #e0e0e0; /* Cor de texto clara */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #1f1f1f; /* Fundo do container */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.7);
            padding: 20px;
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #e0e0e0; /* Cor do título */
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #b3b3b3; /* Cor dos labels */
        }
        input {
            width: 100%;
            padding: 8px 0;
            font-size: 14px;
            border: 1px solid #444; /* Borda do input */
            border-radius: 5px;
            background-color: #2a2a2a; /* Fundo do input */
            color: #e0e0e0; /* Cor do texto do input */
        }
        input::placeholder {
            color: #7a7a7a; /* Cor do placeholder */
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #6a0dad; /* Cor do botão */
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 2rem;
        }
        button:hover {
            background-color: #4b0082; /* Cor do botão ao passar o mouse */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Nome de usuário</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Entrar</button>
        </form>
    </div>

    <script>
        function updateProfileImage() {
            const fileInput = document.getElementById('file-input');
            const profileImg = document.getElementById('profile-img');

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profileImg.src = e.target.result;
                }
                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    </script>
</body>
</html>

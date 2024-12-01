<?php
include('../../security_access/conexao.php');


if(isset($_POST['username']) || isset($_POST['name']) || isset($_POST['email']) || isset($_POST['password']) || isset($_FILES['foto_perfil'])) {
    // upload da imagem: 
    $imagem = $_FILES['foto_perfil'];

    if($imagem['error']) {
        die("falha ao enviar imagem: " . $imagem['error']);
    }

    if($imagem['size'] > 2097152) {
        die("tamanho muito grande!! Max: 2MB");
    }

    $pasta = '../../assets/arquivos/foto_perfil/';
    $nomeDoArquivo = $imagem['name'];
    $novoNomeDoArquivo = uniqid();
    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));

    if($extensao != 'jpg' && $extensao != 'png') {
        die("tipo de arquivo nao aceito");
    }

    $path = $pasta . $novoNomeDoArquivo . '.' . $extensao;
    $deu_certo = move_uploaded_file($imagem['tmp_name'], $path);

    if(!$deu_certo) {
        die("falha ao enviar imagem");  
    }


    $emailValido = $_POST['email'];
    
    $username = $mysqli->real_escape_string($_POST['username']);
    $name = $mysqli->real_escape_string($_POST['name']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $password =  $mysqli->real_escape_string($_POST['password']);

    $sql_code = "SELECT * FROM usuarios WHERE username = '$username'";
    $sql_code2 = "SELECT * FROM usuarios WHERE email = '$email'";
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
    $sql_query2 = $mysqli->query($sql_code2) or die("Falha na execução do código SQL: " . $mysqli->error);

    $quantidade = $sql_query->num_rows;
    $quantidade2 = $sql_query2->num_rows;

    if(strlen($_POST['name']) == 0) {
        echo "<script>alert(\"Preencha seu com seu nome completo.\")</script>";
    } else if(strlen($_POST['email']) == 0) {
        echo "<script>alert(\"Preencha seu email\")</script>";
    } else if(!filter_var($mysqli->real_escape_string($_POST['email']), FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert(\"Email inválido\")</script>";
    } else if($quantidade == 1) {
        echo "<script>alert(\"Esse nome de usuário ja foi utilizado!\")</script>";
    } else if($quantidade2 == 1) {
        echo "<script>alert(\"Esse email ja foi utilizado!\")</script>";
    } else if(strlen($_POST['password']) == 0) {
        echo "<script>alert(\"Preencha sua senha\")</script>";
    } else {

        $sql_code = "INSERT INTO usuarios(foto_perfil, username, nome, email, senha) VALUES ('$path', '$username', '$name', '$email', '$password');";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        header("Location: ../login/");
        
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoSphere | SignUp</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #121212;
            /* Fundo escuro */
            color: #e0e0e0;
            /* Cor de texto clara */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #1f1f1f;
            /* Fundo do container */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.7);
            padding: 20px;
            width: 100%;
            max-width: 400px;
        }

        .profile-picture {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            position: relative;
        }

        .profile-picture img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 3px solid #444;
            /* Borda mais escura */
        }

        .profile-picture input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100px;
            height: 100px;
            opacity: 0;
            cursor: pointer;
        }

        .profile-picture .upload-btn {
            position: absolute;
            bottom: 0;
            right: 150px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #6a0dad;
            /* Cor do botão */
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
            line-height: 50px;
        }

        .profile-picture .upload-btn:hover {
            background-color: #4b0082;
            /* Cor do botão ao passar o mouse */
        }

        .upload-btn::before {
            content: '+';
            color: #ffffff;
            font-size: 20px;
            font-weight: bold;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #e0e0e0;
            /* Cor do título */
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #b3b3b3;
            /* Cor dos labels */
        }

        input {
            width: 100%;
            padding: 8px 0;
            font-size: 14px;
            border: 1px solid #444;
            /* Borda do input */
            border-radius: 5px;
            background-color: #2a2a2a;
            /* Fundo do input */
            color: #e0e0e0;
            /* Cor do texto do input */
        }

        input::placeholder {
            color: #7a7a7a;
            /* Cor do placeholder */
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #6a0dad;
            /* Cor do botão */
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #4b0082;
            /* Cor do botão ao passar o mouse */
        }

        .submit {
            margin-top: 2rem;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="profile-picture">
                <img id="profile-img" src="../../assets/images/userdefault.png" alt="Foto de perfil">
                <input type="file" id="file-input" name="foto_perfil" accept="image/*" onchange="updateProfileImage()"
                    style="display: none;" required>
                <button class="upload-btn" type="button" onclick="document.getElementById('file-input').click()"></button>
            </div>
            <h2>SignUp</h2>
            <div class="form-group">
                <label for="username">Nome de usuário</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="name">Nome completo</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="submit">Entrar</button>
        </form>
    </div>

    <script>
        function updateProfileImage() {
            const fileInput = document.getElementById('file-input');
            const profileImg = document.getElementById('profile-img');

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    profileImg.src = e.target.result;
                }
                reader.readAsDataURL(fileInput.files[0]);
                }
            }
    </script>
</body>

</html>
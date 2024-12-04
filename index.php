<?php
    include('security_access/protect.php');
    include('security_access/conexao.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['postText']) || isset($_POST['postImage'])) {
            $imagem = $_FILES['postImage'];
    
            if ($imagem['error']) {
                die("Falha ao enviar imagem: " . $imagem['error']);
            }
    
            if ($imagem['size'] > 2097152) {
                die("Tamanho muito grande!! Max: 2MB");
            }
    
            $pasta = 'assets/arquivos/imagens/';
            $nomeDoArquivo = $imagem['name'];
            $novoNomeDoArquivo = uniqid();
            $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
    
            if ($extensao != 'jpg' && $extensao != 'jfif') {
                die("Tipo de arquivo não aceito");
            }
    
            $path = $pasta . $novoNomeDoArquivo . '.' . $extensao;
            $deu_certo = move_uploaded_file($imagem['tmp_name'], $path);
    
            if (!$deu_certo) {
                die("Falha ao enviar imagem");  
            }
    
            $texto = $mysqli->real_escape_string($_POST['postText']);
            $id_usuario = $_SESSION['id'];
    
            $sql_code = "INSERT INTO posts(ID_Usuario, URL_midia, Descricao, Visibilidade, Cont_like, Cont_comment, Cont_compartilhamento, Post_delete) 
                         VALUES ($id_usuario, '$path', '$texto', 'public', 0, 0, 0, 0);";
            $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
    
            // Redireciona para evitar reenvio
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    // montagem da estrutura do post 
    $sql = "SELECT p.ID_Post, p.ID_Usuario, p.URL_midia, p.Descricao, p.Visibilidade, p.Cont_like, p.Cont_comment, p.Cont_compartilhamento, u.ID_Usuario, u.Foto_perfil, u.Nome, u.Username 
            FROM posts p 
            INNER JOIN usuarios u ON p.ID_Usuario = u.ID_Usuario 
            WHERE p.Visibilidade = 'public' AND p.ID_Post > 10 
            ORDER BY p.ID_Post DESC;";

    $result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InfoSphere | Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/home.css">
    <script defer src="assets/scripts/homepage.js"></script>
</head>

<body>
    <div class="header-container">
        <div class="conteudo headernb paddingnb">
            <div class="logonb">
                <img src="assets/images/logo.png" alt="InfoSphere">
            </div>
            <div class="nav-usernb" style="padding-top: 20%;">
                <nav>
                    <ul>
                        <li><a href="#"><img src="assets/images/home.svg"> <span>Home</span></a></li>
                        <li><a href="#"><img src="assets/images/notifications.svg"> <span>Notifications</span></a>
                        </li>
                        <li><a href="#"><img src="assets/images/message.svg"> <span>Messages</span></a></li>    
                        <li><a href="#"><img src="assets/images/menu.svg"> <span>More</span></a></li>
                        <button style = "background-color: transparent; border: none;" type="button" data-bs-toggle="modal" data-bs-target="#newPost"><li class="new-post"><a><img src="assets/images/add.svg"> <span>New post</span></a>
                        </li></button>
                    </ul>
                </nav>
                <div class="usernb" style="margin-top: 5%;">
                    <div class="user-imagenb">
                        <img src="<?php echo str_replace('../../', '', $_SESSION['foto']); ?>" alt="User">
                    </div>
                    <div class="user-info">
                        <p><?php echo $_SESSION['nome']; ?></p>
                        <p class="nickname"><?php echo "@".$_SESSION['username']; ?></p>
                    </div>
                    <a href="security_access/logout.php"><img src="assets/images/more.svg" alt=""></a>
                </div>
            </div>
        </div>
    </div class="header-container">
    <main>
        <div class="conteudo">
            <div class="sticky-header" style="width:100%;">
                <div class="header-conteudo">
                    <div class="fixed-header">
                        <div class="div">
                            <p>For You</p>
                        </div>
                        <div class="div">
                            <p>Following</p>
                        </div>
                    </div>
                </div>
                <div class="posts">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if($_SESSION['id'] == $row['ID_Usuario']) {
                                echo '<div class="post">
                                    <div class="user">
                                        <div class="display-row-header">
                                            <div class="image">
                                                <div class="imageuser-post">
                                                    <img src="' . htmlspecialchars(str_replace('../../', '',$row['Foto_perfil'])) . '" alt="User">
                                                </div>
                                            </div>
                                            <div class="display-column">
                                                <div class="user-info">
                                                    <p style="white-space: nowrap;">' . htmlspecialchars($row['Nome']) . '</p>
                                                    <p style="white-space: nowrap;"><span>@' . htmlspecialchars($row['Username']) . '</span></p>
                                                    <div style = "width:100%; display:flex; flex-direction:column; align-items:end;">
                                                        <div class="more">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed" data-bs-toggle="dropdown" style="cursor: pointer;">
                                                                <path d="M240-400q-33 0-56.5-23.5T160-480q0-33 23.5-56.5T240-560q33 0 56.5 23.5T320-480q0 33-23.5 56.5T240-400Zm240 0q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm240 0q-33 0-56.5-23.5T640-480q0-33 23.5-56.5T720-560q33 0 56.5 23.5T800-480q0 33-23.5 56.5T720-400Z"/>
                                                            </svg>

                                                            <div class="dropdown-menu dropdown-menu-end bg-dark text-light" aria-labelledby="dropdownMenuButton">
                                                                <button style = "background-color: transparent; border: none;" type="button" data-bs-toggle="modal" data-bs-target="#editPost"><a class="dropdown-item text-light bg-dark hover:bg-secondary" style="cursor: pointer;">Editar Post</a></button>
                                                                <a class="dropdown-item text-light bg-dark hover:bg-secondary" style="cursor: pointer;">Remover Post</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-container">'.htmlspecialchars($row['Descricao']).'</div>
                                                <div class="post-content">
                                                    <img src="' . htmlspecialchars($row['URL_midia']) . '" class="midia">
                                                </div>
                                                <div class="post-actions">
                                                    <div class="left">
                                                        <div class="like action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/></svg>
                                                            <span>' . htmlspecialchars($row['Cont_like']) . '</span>
                                                        </div>
                                                        <div class="comment action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M480-80 373-240H160q-33 0-56.5-23.5T80-320v-480q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H587L480-80Zm0-144 64-96h256v-480H160v480h256l64 96Zm0-336Z"/></svg>
                                                            <span>' . htmlspecialchars($row['Cont_comment']) . '</span>
                                                        </div>
                                                        <div class="views action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M640-160v-280h160v280H640Zm-240 0v-640h160v640H400Zm-240 0v-440h160v440H160Z"/></svg>
                                                            <span>' . htmlspecialchars($row['Cont_compartilhamento']) . '</span>
                                                        </div>
                                                        <div class="share action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M680-80q-50 0-85-35t-35-85q0-6 3-28L282-392q-16 15-37 23.5t-45 8.5q-50 0-85-35t-35-85q0-50 35-85t85-35q24 0 45 8.5t37 23.5l281-164q-2-7-2.5-13.5T560-760q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35q-24 0-45-8.5T598-672L317-508q2 7 2.5 13.5t.5 14.5q0 8-.5 14.5T317-452l281 164q16-15 37-23.5t45-8.5q50 0 85 35t35 85q0 50-35 85t-85 35Zm0-80q17 0 28.5-11.5T720-200q0-17-11.5-28.5T680-240q-17 0-28.5 11.5T640-200q0 17 11.5 28.5T680-160ZM200-440q17 0 28.5-11.5T240-480q0-17-11.5-28.5T200-520q-17 0-28.5 11.5T160-480q0 17 11.5 28.5T200-440Zm480-280q17 0 28.5-11.5T720-760q0-17-11.5-28.5T680-800q-17 0-28.5 11.5T640-760q0 17 11.5 28.5T680-720Zm0 520ZM200-480Zm480-280Z"/></svg>
                                                            <span>' . htmlspecialchars($row['Cont_compartilhamento']) . '</span>
                                                        </div>
                                                    </div>
                                                    <div class="right">
                                                        <div class="favorite">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="m354-287 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143ZM233-120l65-281L80-590l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Zm247-350Z"/></svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                                // editar post
                                $idPost = $row['ID_Post'];

                                $sql = "SELECT Descricao FROM posts WHERE ID_Post = $idPost;";
                                $result = $mysqli->query($sql);
                                $row = $result->fetch_assoc();

                            } else {
                                echo '<div class="post">
                                    <div class="user">
                                        <div class="display-row-header">
                                            <div class="image">
                                                <div class="imageuser-post">
                                                    <img src="' . htmlspecialchars(str_replace('../../', '',$row['Foto_perfil'])) . '" alt="User">
                                                </div>
                                            </div>
                                            <div class="display-column">
                                                <div class="user-info">
                                                    <p style="white-space: nowrap;">' . htmlspecialchars($row['Nome']) . '</p>
                                                    <p style="white-space: nowrap;"><span>@' . htmlspecialchars($row['Username']) . '</span></p>
                                                    <div style = "width:100%; display:flex; flex-direction:column; align-items:end;">
                                                        <div class="more">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed" data-bs-toggle="dropdown" style="cursor: pointer;">
                                                                <path d="M240-400q-33 0-56.5-23.5T160-480q0-33 23.5-56.5T240-560q33 0 56.5 23.5T320-480q0 33-23.5 56.5T240-400Zm240 0q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm240 0q-33 0-56.5-23.5T640-480q0-33 23.5-56.5T720-560q33 0 56.5 23.5T800-480q0 33-23.5 56.5T720-400Z"/>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-container">'.htmlspecialchars($row['Descricao']).'</div>
                                                <div class="post-content">
                                                    <img src="' . htmlspecialchars($row['URL_midia']) . '" class="midia">
                                                </div>
                                                <div class="post-actions">
                                                    <div class="left">
                                                        <div class="like action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/></svg>
                                                            <span>' . htmlspecialchars($row['Cont_like']) . '</span>
                                                        </div>
                                                        <div class="comment action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M480-80 373-240H160q-33 0-56.5-23.5T80-320v-480q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H587L480-80Zm0-144 64-96h256v-480H160v480h256l64 96Zm0-336Z"/></svg>
                                                            <span>' . htmlspecialchars($row['Cont_comment']) . '</span>
                                                        </div>
                                                        <div class="views action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M640-160v-280h160v280H640Zm-240 0v-640h160v640H400Zm-240 0v-440h160v440H160Z"/></svg>
                                                            <span>' . htmlspecialchars($row['Cont_compartilhamento']) . '</span>
                                                        </div>
                                                        <div class="share action">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M680-80q-50 0-85-35t-35-85q0-6 3-28L282-392q-16 15-37 23.5t-45 8.5q-50 0-85-35t-35-85q0-50 35-85t85-35q24 0 45 8.5t37 23.5l281-164q-2-7-2.5-13.5T560-760q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35q-24 0-45-8.5T598-672L317-508q2 7 2.5 13.5t.5 14.5q0 8-.5 14.5T317-452l281 164q16-15 37-23.5t45-8.5q50 0 85 35t35 85q0 50-35 85t-85 35Zm0-80q17 0 28.5-11.5T720-200q0-17-11.5-28.5T680-240q-17 0-28.5 11.5T640-200q0 17 11.5 28.5T680-160ZM200-440q17 0 28.5-11.5T240-480q0-17-11.5-28.5T200-520q-17 0-28.5 11.5T160-480q0 17 11.5 28.5T200-440Zm480-280q17 0 28.5-11.5T720-760q0-17-11.5-28.5T680-800q-17 0-28.5 11.5T640-760q0 17 11.5 28.5T680-720Zm0 520ZM200-480Zm480-280Z"/></svg>
                                                            <span>' . htmlspecialchars($row['Cont_compartilhamento']) . '</span>
                                                        </div>
                                                    </div>
                                                    <div class="right">
                                                        <div class="favorite">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="m354-287 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143ZM233-120l65-281L80-590l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Zm247-350Z"/></svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                            }
                        }
                    } else {
                        echo 'Nenhum post encontrado.';
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="search-input">
            <div class="fixed-search">
                <input type="text" placeholder="Search" class="search">
            </div>
        </div>
    </footer>

  <!-- Modal novo post -->
    <div class="modal fade" id="newPost" tabindex="-1" aria-labelledby="post" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="post">Create new post</h1>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="postText" class="form-label">Post content</label>
            <textarea class="form-control bg-dark text-light" id="postText" name="postText" rows="4" placeholder="Write your post here..." required></textarea>
          </div>
          <div class="mb-3">
            <label for="postImage" class="form-label">Upload photo</label>
            <input class="form-control bg-dark text-light" type="file" id="postImage" name="postImage" accept="image/*" required>
          </div>
          <div class="modal-footer" style="border-top: none;">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary"  style="background-color: #8B32F9;">Done</button>
        </div>
        </form>
        </div>
        </div>
    </div>
    </div>

    <!-- Modal editar post -->
        <div class="modal fade" id="editPost" tabindex="-1" aria-labelledby="post" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="post">Create new post</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="postText" class="form-label">Post content</label>
                <textarea class="form-control bg-dark text-light" id="postText" name="postText" rows="4" placeholder="Write your post here..." required></textarea>
            </div>
            <div class="modal-footer" style="border-top: none;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary"  style="background-color: #8B32F9;">Done</button>
            </div>
            </form>
            </div>
            </div>
        </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

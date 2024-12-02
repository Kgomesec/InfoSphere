<?php
    include('security_access/protect.php');
    include('security_access/conexao.php');

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoSphere | Home</title>
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
                        <li class="new-post"><a href="#"><img src="assets/images/add.svg"> <span>New post</span></a>
                        </li>
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
            <div class="sticky-header">
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
                    <div class="post">
                        <div class="user">
                            <div class="display-row-header">
                                <div class="image">
                                    <div class="imageuser-post">
                                        <img src="assets/images/userdefault.png" alt="User">
                                    </div>
                                </div>
                                <div class="display-column">
                                    <div class="user-info">
                                        <p>Nome do usuário</p>
                                        <p><span>@usuario • 11h</span></p>
                                    </div>
                                    <div class="text-container">
                                        <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec nunc nec libero ultricies aliquet. Nullam nec nunc nec libero ultricies aliquet.</p> -->
                                    </div>
                                    <div class="post-content">
                                        <img src="https://pbs.twimg.com/media/GdbHxjjWsAEj_oN?format=jpg&name=small"
                                            class="midia">
                                    </div>
                                    <div class="post-actions">
                                        <div class="left">
                                            <div class="like action">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/></svg>
                                                <span>12</span>
                                            </div>
                                            <div class="comment action">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M480-80 373-240H160q-33 0-56.5-23.5T80-320v-480q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H587L480-80Zm0-144 64-96h256v-480H160v480h256l64 96Zm0-336Z"/></svg>
                                                <span>3</span>
                                            </div>
                                            <div class="views action">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M640-160v-280h160v280H640Zm-240 0v-640h160v640H400Zm-240 0v-440h160v440H160Z"/></svg>
                                                <span>30</span>
                                            </div>
                                            <div class="share action">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M680-80q-50 0-85-35t-35-85q0-6 3-28L282-392q-16 15-37 23.5t-45 8.5q-50 0-85-35t-35-85q0-50 35-85t85-35q24 0 45 8.5t37 23.5l281-164q-2-7-2.5-13.5T560-760q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35q-24 0-45-8.5T598-672L317-508q2 7 2.5 13.5t.5 14.5q0 8-.5 14.5T317-452l281 164q16-15 37-23.5t45-8.5q50 0 85 35t35 85q0 50-35 85t-85 35Zm0-80q17 0 28.5-11.5T720-200q0-17-11.5-28.5T680-240q-17 0-28.5 11.5T640-200q0 17 11.5 28.5T680-160ZM200-440q17 0 28.5-11.5T240-480q0-17-11.5-28.5T200-520q-17 0-28.5 11.5T160-480q0 17 11.5 28.5T200-440Zm480-280q17 0 28.5-11.5T720-760q0-17-11.5-28.5T680-800q-17 0-28.5 11.5T640-760q0 17 11.5 28.5T680-720Zm0 520ZM200-480Zm480-280Z"/></svg>
                                                <span>5</span>
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
                    </div>

                    <!-- <div class="post">
                    <div class="user">
                        <div class="user-image">
                            <img src="../assets/images/userdefault.png" alt="User">
                        </div>
                        <div class="user-info">
                            <p>Nome do usuário</p>
                            <p class="nickname">@usuario · Nov 26</p>
                        </div>
                    </div>
                    <div class="post-content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec nunc nec
                            libero
                            ultricies
                            aliquet. Nullam nec nunc nec libero ultricies aliquet.</p>
                    </div>
                    <div class="post-actions">
                        <div class="like">
                            <img src="../assets/images/like.svg" alt="Like">
                            <span>12</span>
                        </div>
                        <div class="comment">
                            <img src="../assets/images/comment.svg" alt="Comment">
                            <span>3</span>
                        </div>
                        <div class="share">
                            <img src="../assets/images/share.svg" alt="Share">
                            <span>5</span>
                        </div>
                    </div>
                </div> -->
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
</body>
</html>

<?php
include '../app/lib/functions.php';

$blogs = $data['blogs'];
$comments = $data['comments'];
$tagCloud = $data['tagCloud'];

?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html" ; charset="utf-8" />
    <link href='http://fonts.googleapis.com/css?family=Irish+Grover' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=La+Belle+Aurore' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="./public/css/">
    <link href="css/screen.css" type="text/css" rel="stylesheet" />
    <link href="css/sidebar.css" type="text/css" rel="stylesheet" />
    <link href="css/blog.css" type="text/css" rel="stylesheet" />
    <link href="css/web.css" type="text/css" rel="stylesheet">
</head>

<body>
    <section id="wrapper">
        <header id="header">
            <div class="top">
                <nav>
                    <ul class="navigation">
                        <li><a href="/">Home</a></li>
                        <li><a href="/about">About</a></li>
                        <?php
                        if (isset($_SESSION['userId'])) {
                            echo
                                '<li><a href="/contact">Contact</a></li>
                                    <li><a href="/admin">Admin</a></li>
                                    <li><a href="/logout">Logout</a></li>';
                        } else {
                            echo '<li><a href="/login">Login</a></li>';
                        }
                        ?>
                    </ul>
                </nav>
            </div>
            <hgroup>
                <h2><a href="/">symblog</a></h2>
                <h3><a href="/">creating a blog in Symfony2 by Laura Luque</a></h3>
            </hgroup>
        </header>
        <section class="main-col">
            <h1>Crea un blog</h1>
            <?php
            // Verificar si hay una cookie de mensaje de éxito y mostrarlo en consecuencia
            if (isset($_COOKIE['success_message'])) {
                $successMessage = $_COOKIE['success_message'];
                echo '<div class="blogger-notice">' . $successMessage . '</div>';
                // Eliminar la cookie después de mostrar el mensaje
                setcookie('success_message', '', time() - 3600, '/');
            }
            ?>
            <form class="blogger" action="/addBlog" method="post" enctype="multipart/form-data">
                <div>
                    <label for="title">Título:</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div>
                    <label for="description">Descripción:</label>
                    <textarea id="description" name="description" cols="30" rows="10"></textarea>
                </div>
                <div>
                    <label for="tags">Tags:</label>
                    <input type="text" id="tags" name="tags" required>
                </div>
                <div>
                    <label for="author">Autor:</label>
                    <input type="text" id="author" name="author" required>
                </div>
                <div>
                    <label for="image">Image</label>
                    <input type="file" id="image" name="image" />
                </div>
                <div>
                    <input type="submit" name="submit" value="Submit" />
                </div>
            </form>
        </section>
        <aside class="sidebar">
            <section class="section">
                <header>
                    <h3>Tag Cloud</h3>
                </header>
                <p class="tags">
                    <?php
                    foreach ($tagCloud as $tag => $count) {
                        if ($count >= 5) {
                            echo "<span class=\"weight-5\">" . $tag . "</span>";
                        } else {
                            echo "<span class=\"weight-" . $count . "\">" . $tag . "</span>";
                        }
                    }
                    ?>
                </p>
            </section>
            <section class="section">
                <header>
                    <h3>Latest Comments</h3>
                </header>
                <article class="comment">
                    <?php
                    foreach ($comments as $comment) {
                        if ($comment) {
                            echo "<header>
                                    <p class=\"small\"><span class=\"highlight\">" . $comment->user . "</span> commented on
                                    <a href=\"#\">" . ($comment->blog ? $comment->blog->title : 'Unknown Blog') . "</a>
                                    </p>
                                </header>
                                <p>" . $comment->comment . "</p>";
                        }
                    }
                    ?>
                </article>
            </section>
        </aside>
        <div id="footer">
            dwes symblog - created by <a href="#">Laura Luque</a>
        </div>
    </section>
</body>

</html>
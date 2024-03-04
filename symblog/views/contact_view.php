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
            <form class="blogger" action="#" method="post">
                <div>
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre">
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">
                </div>
                <div>
                    <label for="mensaje">Mensaje:</label>
                    <textarea id="mensaje" name="mensaje"></textarea>
                </div>
                <div>
                    <input type="submit" value="Enviar">
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
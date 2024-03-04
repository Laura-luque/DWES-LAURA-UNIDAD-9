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
    <link href="./css/screen.css" type="text/css" rel="stylesheet" />
    <link href="./css/sidebar.css" type="text/css" rel="stylesheet" />
    <link href="./css/blog.css" type="text/css" rel="stylesheet" />
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
            <h2>About</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit iusto illum placeat! At velit
                provident veniam ex. Nesciunt nihil atque possimus sed soluta porro sunt quae. Numquam provident sed et!
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, nobis hic, recusandae ut neque quidem
                cupiditate molestiae sit temporibus distinctio qui alias quod veritatis rerum vero, labore cumque
                placeat tenetur. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Repudiandae inventore iusto
                ex, nemo similique excepturi soluta odio commodi aliquid dolore, asperiores omnis? Molestias rem animi,
                incidunt saepe eveniet sed perspiciatis.</p>
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
                            echo 
                            "<header>  
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
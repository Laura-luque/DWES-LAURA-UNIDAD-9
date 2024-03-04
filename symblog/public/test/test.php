<?php
require '../../bootstrap.php';
use App\Models\{Blog, Comment, Users};

// $blog = Blog::Create([
//     'title' => "Almeja2 Khan",
//     'author' => "ahmed.khan@lbs.com",
//     'blog' => "skjfn",
//     'image' => "jght.png",
//     'tags' => "php",
// ]);

// print_r($blog->comment()->create([
//     'user' => "Working with Eloquent Without PHP",
//     'comment' => "eloquent",
//     'approved' => 1
//     ]));

// print_r(Blog::all('author')); // todos
// print_r(Blog::find(34));
// $pepe = Blog::all();

//Saca los blogs y sus comentarios
// $pepe = Blog::all();
// foreach ($pepe as $value) {
//     echo "<br/><br/>Blog: ".$value->title."<br/><br/>";
//     $value->getComments();
// }

// Busca un blog por id y muestra sus comentarios
// foreach (Blog::find(26)->comment as $value) {
//     var_dump($value->comment);
// }

// De todos los blogs, saca los usuarios de los que han comentado en algun blog
// foreach ($pepe as $key => $blog) {
//     foreach ($blog->comment as $key2 => $comment) {
//         var_dump($comment->user);
//     }
// }


// print_r($pepe->user); // busca por id

// var_dump($pepe->tagsUnique());


//Creación usuarios
// $user1 = Users::Create([
//         'email' => "ahmed.khan@lbs.com",
//         'password' => "almeja1",
//     ]);
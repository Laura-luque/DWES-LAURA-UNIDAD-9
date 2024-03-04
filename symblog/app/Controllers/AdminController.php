<?php
namespace App\Controllers;
use App\Models\Blog;
use Laminas\Diactoros\Response\HtmlResponse;


class AdminController extends BaseController{
    public function getIndex(){

        $data = [];
        $blogs = Blog::all();
        // $data['blogs'] = $blogs;

        // Inicializar el array de comentarios
        $data['comments'] = [];

        $data['tags'] = [];


        // Sacar todos los comentarios de todos los blogs
        foreach ($blogs as $blog) {
            foreach ($blog->comment as $comment) {
                $data['comments'][] = $comment; // Agrega el objeto completo del comentario
            }
            // Obtener los tags de cada blog
            $tags = explode(',', $blog->tags); // Suponiendo que los tags están separados por comas
            $data['tags'] = array_merge($data['tags'], $tags);
        };
        // Seleccionar los últimos 5 comentarios
        $data['comments'] = array_slice($data['comments'], -5);

        // Obtener la nube de tags
        $tagCount = array_count_values($data['tags']);
        $data['tagCloud'] = $tagCount;
        return new HtmlResponse($this->renderHTML('../views/admin_view.php', $data));
    }

    
}
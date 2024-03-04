<?php

namespace App\Controllers;

use App\Models\{Blog, Users, Comment};
use Respect\Validation\Validator as v;
use Laminas\Diactoros\Response\HtmlResponse;


class IndexControllers extends BaseController
{
    public function indexAction()
    {
        $data = [];
        // $blogs = Blog::all();
        $blogs = Blog::orderBy('created', 'desc')->get();
        $data['blogs'] = $blogs;

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
        }

        // Seleccionar los últimos 5 comentarios
        $data['comments'] = array_slice($data['comments'], -5);

        // Obtener la nube de tags
        $tagCount = array_count_values($data['tags']);
        $data['tagCloud'] = $tagCount;
        

        return new HtmlResponse($this->renderHTML('../views/index_view.php', $data));
    }


    public function aboutAction()
    {
        $data = [];
        $blogs = Blog::all();
        $data['blogs'] = $blogs;

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

        return new HtmlResponse($this->renderHTML('../views/about_view.php', $data));
    }

    public function addBlogAction($request){
        $responseMessage = null;
        
        $postData = $request->getParsedBody();
        $blogValidator = v::key('title',v::stringType()->notEmpty())
                        ->key('description',v::stringType()->notEmpty())
                        ->key('tags',v::stringType()->notEmpty())
                        ->key('author',v::stringType()->notEmpty());

        try {
            $blogValidator -> assert($postData);

            $blog = Blog::create([
                'title' => $postData['title'],
                'author' => $postData['author'],
                'blog' => $postData['description'],
                'tags' => $postData['tags'],
            ]);

            //carga de ficheros
            $files = $request ->getUploadedFiles();
            var_dump($files);
            $imagen = $files['image'];
            if($imagen->getError() == UPLOAD_ERR_OK){
                $fileName = $imagen->getClientFilename();
                $fileName = uniqid().$fileName;
                $imagen->moveTO("../public/img/$fileName");
                $blog-> image = $fileName;
            }
            $blog->save();
            $responseMessage = "Saved";
        } catch (\Exception $e){
            $responseMessage = $e->getMessage();
        }
        
        // Establecer una cookie con el mensaje de éxito
        setcookie('success_message', 'El blog se ha añadido exitosamente', time() + 60, '/');

        // Redireccionar a una página diferente después de agregar el blog
        header("Location: /addBlog");
        exit();
        // return $this->renderHTML('../views/addBlog_view.php');
    }

    public function newBlogAction()
{
    $data = [];
        $blogs = Blog::all();
        $data['blogs'] = $blogs;

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

        return new HtmlResponse($this->renderHTML('../views/addBlog_view.php', $data));
}

    public function contactAction()
    {
        $data = [];
        $blogs = Blog::all();
        $data['blogs'] = $blogs;

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
        return new HtmlResponse($this->renderHTML('../views/contact_view.php', $data));
    }

    public function showAction($request)
    {
        $data = [];
        $data['blog'] = Blog::find($_GET['id']);
        $data['user'] = isset($_SESSION['userId']) ? Users::find($_SESSION['userId']) : null;
        $data['comments'] = [];

        $data['tags'] = [];

        // Sacar todos los comentarios de todos los blogs
        foreach (Blog::all() as $blog) {
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
        return new HtmlResponse($this->renderHTML('../views/show_view.php', $data));
    }

    public function addComments($request) {

        $postData = $request->getParsedBody();
        $commentValidador = v::key('comment',v::stringType()->notEmpty());
        $commentValidador -> assert($postData);

        $comment = Comment::create([
            'blog_id'=> $_GET['id'],
            'user' => Users::find($_SESSION['userId'])->email,
            'comment' => $postData['comment'],
            'approved' => 1
        ]);
        $comment->save();

        header('Location: /show?id='.$_GET["id"].'');
        exit();

    }

}

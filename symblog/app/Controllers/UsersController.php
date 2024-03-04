<?php
namespace App\Controllers;
use App\Models\{Users, Blog};
use Laminas\Diactoros\Response\HtmlResponse;

class UsersController extends BaseController
{
    public function addUserAction($request)
    {

        $postData = $request->getParsedBody();

        $user = new Users();
        $user->email = $postData['email'];
        $user->password = password_hash($postData["password"], PASSWORD_BCRYPT);
        $user->save();

        // Establecer una cookie con el mensaje de éxito
        setcookie('success_message', 'Usuario añadido correctamente', time() + 60, '/');

        // Redireccionar a una página diferente después de agregar el usuario
        header("Location: /addUser");
        exit();
        
    }

    public function newUserAction() {
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
        return new HtmlResponse($this->renderHTML('../views/addUser_view.php', $data));
    }
}
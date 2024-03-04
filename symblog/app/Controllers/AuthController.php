<?php
namespace App\Controllers;
use App\Models\{Users, Blog};
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\Response\HtmlResponse;

class AuthController extends BaseController
{
    public function formLoginAction() {
        $data = [];
        $blogs = Blog::all();

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
        return new HtmlResponse($this->renderHTML('../views/login_view.php', $data));
    }

    public function postLoginAction($request) {
        // var_dump($request);
        $postData = $request->getParsedBody();
        $responseMessage = null;

        $user = Users::where("email", $postData["email"])->first();
        if($user){
            if(password_verify($postData["password"], $user->password)){
                $_SESSION["userId"] = $user->id;
                $responseMessage = "OK Credentials";
                return new RedirectResponse("/admin");
            } else {
                echo "poosdata   ".$postData["password"];
                echo "user pass  ".$user->password;
                $responseMessage = "Bad Credentials 222";
            }
        } else{
            $responseMessage = "Bad Credentials";
        }

        $data = [];
        $blogs = Blog::all();

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
        $data['respuesta'] = $responseMessage;
        return new HtmlResponse($this->renderHTML('../views/login_view.php', $data));

    }

    public function getLogout(){
        unset($_SESSION["userId"]);
        return new RedirectResponse("/login");
    }

}
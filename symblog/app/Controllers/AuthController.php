<?php
namespace App\Controllers;
use App\Models\{Users, Blog, Comment};
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\Response\HtmlResponse;

class AuthController extends BaseController
{
    public function formLoginAction() {
        $data = [];
        $blogs = Blog::all();
        $data['comments'] = [];
        $data['tags'] = [];

        foreach ($blogs as $blog) {
            foreach ($blog->comment as $comment) {
                $data['comments'][] = $comment; 
            }
            $tags = explode(',', $blog->tags);
            $data['tags'] = array_merge($data['tags'], $tags);
        };
        $data['comments'] = array_reverse(array_slice($data['comments'], -5));
        $tagCount = array_count_values($data['tags']);
        $data['tagCloud'] = $tagCount;

        return $this->renderHTML('login.twig', [
            'blogs' => $blogs,
            'comments' => $data['comments'],
            'tagCloud' => $data['tagCloud']
        ]);
    }

    public function postLoginAction($request) {
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
        $data['comments'] = [];
        $data['tags'] = [];

        foreach ($blogs as $blog) {
            foreach ($blog->comment as $comment) {
                $data['comments'][] = $comment;
            }
            $tags = explode(',', $blog->tags);
            $data['tags'] = array_merge($data['tags'], $tags);
        };
        $data['comments'] = array_reverse(array_slice($data['comments'], -5));

        $tagCount = array_count_values($data['tags']);
        $data['tagCloud'] = $tagCount;
        $data['respuesta'] = $responseMessage;

        return $this->renderHTML('login.twig', [
            'blogs' => $blogs,
            'comments' => $data['comments'],
            'tagCloud' => $data['tagCloud']
        ]);
    }

    public function getLogout(){
        unset($_SESSION["userId"]);
        return new RedirectResponse("/login");
    }

}
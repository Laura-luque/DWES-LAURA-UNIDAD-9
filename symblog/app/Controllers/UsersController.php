<?php
namespace App\Controllers;
use App\Models\{Users, Blog, Comment};
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

        $cookie = setcookie('success_message', 'El blog se ha añadido exitosamente', time() + 60, '/');

        $data = [];
        $blogs = Blog::all();
        $data['blogs'] = $blogs;
        $user = isset($_SESSION['userId']) ? Users::find($_SESSION['userId'])->id : null;

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

        return $this->renderHTML('addUser.twig', [
            'cookie' => $cookie,
            'blogs' => $blogs,
            'comments' => $data['comments'],
            'tagCloud' => $data['tagCloud'],
            'userId' => $user
        ]);
    }

    public function newUserAction() {
        $data = [];
        $blogs = Blog::all();
        $data['comments'] = [];
        $user = isset($_SESSION['userId']) ? Users::find($_SESSION['userId'])->id : null;
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
        return $this->renderHTML('addUser.twig', [
            'blogs' => $blogs,
            'comments' => $data['comments'],
            'tagCloud' => $data['tagCloud'],
            'userId' => $user
        ]);
    }
}
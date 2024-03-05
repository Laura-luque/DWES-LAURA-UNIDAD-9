<?php

namespace App\Controllers;

use App\Models\{Blog, Users};
use App\Models\Comment;
use Respect\Validation\Validator as v;
use Laminas\Diactoros\Response\HtmlResponse;



class IndexControllers extends BaseController
{
    public function indexAction()
    {
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

        return $this->renderHTML('index.twig', [
            'blogs' => array_reverse($blogs->toArray()),
            'comments' => $data['comments'],
            'tagCloud' => $data['tagCloud'],
            'userId' => $user
        ]);
    }


    public function aboutAction()
    {
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

        return $this->renderHTML('about.twig', [
            'blogs' => $blogs,
            'comments' => $data['comments'],
            'tagCloud' => $data['tagCloud'],
            'userId' => $user
        ]);
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

            $files = $request ->getUploadedFiles();
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

        return $this->renderHTML('addBlog.twig', [
            'cookie' => $cookie,
            'blogs' => $blogs,
            'comments' => $data['comments'],
            'tagCloud' => $data['tagCloud'],
            'userId' => $user
        ]);
    }

    public function newBlogAction()
{
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

    return $this->renderHTML('addBlog.twig', [
        'blogs' => $blogs,
        'comments' => $data['comments'],
        'tagCloud' => $data['tagCloud'],
        'userId' => $user
    ]);
}

    public function contactAction()
    {
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
        return $this->renderHTML('contact.twig', [
            'blogs' => $blogs,
            'comments' => $data['comments'],
            'tagCloud' => $data['tagCloud'],
            'userId' => $user
        ]);
    }

    public function showAction($request)
    {
        $data = [];
        $data['blog'] = Blog::find($_GET['id']);
        $user = isset($_SESSION['userId']) ? Users::find($_SESSION['userId'])->id : null;
        $userEmail = isset($_SESSION['userId']) ? Users::find($_SESSION['userId'])->email : null;

        $data['comments'] = [];
        $data['tags'] = [];

        foreach (Blog::all() as $blog) {
            foreach ($blog->comment as $comment) {
                $data['comments'][] = $comment; 
            }
            $tags = explode(',', $blog->tags);
            $data['tags'] = array_merge($data['tags'], $tags);
        };

        $data['comments'] = array_reverse(array_slice($data['comments'], -5));

        $tagCount = array_count_values($data['tags']);
        $data['tagCloud'] = $tagCount;
        return $this->renderHTML('show.twig', [
            'blog' => $data['blog'],
            'comments' => $data['comments'],
            'tagCloud' => $data['tagCloud'],
            'userId' => $user,
            'userEmail' => $userEmail
        ]);
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

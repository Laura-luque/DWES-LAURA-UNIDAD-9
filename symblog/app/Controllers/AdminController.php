<?php
namespace App\Controllers;
use App\Models\{Users, Blog};
use Laminas\Diactoros\Response\HtmlResponse;

class AdminController extends BaseController{
    public function getIndex(){

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

        return $this->renderHTML('admin.twig', [
            'blogs' => $blogs,
            'comments' => $data['comments'],
            'tagCloud' => $data['tagCloud'],
            'userId' => $user
        ]);
    }
}
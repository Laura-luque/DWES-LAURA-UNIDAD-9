<?php
namespace App\Models;

class Blog extends DBAbstractModel 
{
    //Singleton
    private static $instancia;
    public static function getInstancia()
    {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

    public function __clone()
    {
        trigger_error("La clonación no está permitida.", E_USER_ERROR);
    }

    private $id;
    private $title;
    private $author;
    private $blog;
    private $image;
    private $tags;
    private $created;
    private $updated;

    private $comments = [];

    public function setID($id)
    {
        $this->id = $id;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }
    public function setBlog($blog)
    {
        $this->blog = $blog;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function setTags($tags)
    {
        $this->tags = $tags;
    }
    public function setCreated($date) {
        $this->created = date("Y-m-d H:m:s", $date->getTimestamp());
    }

    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    public function getTitle() {
        return $this->title;
    }
    public function getAuthor() {
        return $this->author;
    }
    public function getBlog() {
        return $this->blog;
    }
    public function getMensaje() {
        return $this->mensaje;
    }
    public function getImage() {
        return $this->image;
    }
    public function getTags() {
        return $this->tags;
    }
    public function getCreated() {
        return $this->created;
    }
    public function getUpdated() {
        return $this->updated;
    }

    public function addComment($comment){
        $this->comments[] = $comment;
    }

    public function setComments(array $comments) {
        $this->comments = $comments;
    }

    public function get() {
        
    }
    public function set() {
            $this->query = "INSERT INTO blog(title,author,blog, image, tags, created, updated) VALUES(:title, :author, :blog, :image, :tags, :created, :updated)";
            $this->parametros['title'] = $this->getTitle();
            $this->parametros['author'] = $this->getAuthor();
            $this->parametros['blog'] = $this->getBlog();
            $this->parametros['image'] = $this->getImage();
            $this->parametros['tags'] = $this->getTags();
            $this->parametros['created'] = $this->getCreated();
            $this->parametros['updated'] = $this->getUpdated();
            $this->get_results_from_query();
            $this->mensaje = 'Blog añadido';
        
    }
    public function edit() {

    }
    public function delete() {

    }
}
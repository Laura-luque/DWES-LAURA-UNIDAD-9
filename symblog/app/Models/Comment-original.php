<?php
namespace App\Models;

class Comment extends DBAbstractModel
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
    private $blog_id;
    private $user;
    private $comment;
    private $approved;
    private $created;
    private $updated;

    public function setID($id)
    {
        $this->id = $id;
    }

    public function setBlog_id($blog_id)
    {
        $this->blog_id = $blog_id;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function setApproved($approved = 1)
    {
        $this->approved = $approved;
    }

    public function setCreated($date = new \DateTime())
    {
        $this->created = date("Y-m-d H:m:s", $date->getTimestamp());
    }

    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    public function getBlog_id()
    {
        return $this->blog_id;
    }
    public function getUser()
    {
        return $this->user;
    }
    public function getComment()
    {
        return $this->comment;
    }
    public function getMensaje()
    {
        return $this->mensaje;
    }
    public function getApproved()
    {
        return $this->approved;
    }

    public function getCreated()
    {
        return $this->created;
    }
    public function getUpdated()
    {
        return $this->updated;
    }

    public function setBlog($blog) {
        $this->query = "SELECT id
        FROM blog WHERE title = :title";
        $this->parametros["title"] = $blog->getTitle();
        $this->get_results_from_query();
        // var_dump($this->rows);
        // exit;
        $this->blog_id = $this->rows[0]["id"];
    }

    public function get()
    {

    }
    public function set()
    {
        $this->setCreated();
        $this->setUpdated($this->getCreated());
        $this->setApproved();

        $this->query = "INSERT INTO comment(blog_id,user,comment, approved,created, updated) VALUES(:blog_id, :user, :comment, :approved, :created, :updated)";
        $this->parametros['blog_id'] = $this->getBlog_id();
        $this->parametros['user'] = $this->getUser();
        $this->parametros['comment'] = $this->getComment();
        $this->parametros['approved'] = $this->getApproved();
        $this->parametros['created'] = $this->getCreated();
        $this->parametros['updated'] = $this->getUpdated();
        $this->get_results_from_query();
        $this->mensaje = 'Comentario añadido';
    }
    public function edit()
    {

    }
    public function delete()
    {

    }
}
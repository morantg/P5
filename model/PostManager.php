<?php


class PostManager
{
    
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getPosts()
    {
        $req = $this->db->query('SELECT id, titre, contenu, DATE_FORMAT(dateAjout, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM news ORDER BY dateAjout DESC LIMIT 0, 5');
        return $req;
    }

    public function getPost($postId)
    {
        $req = $this->db->prepare('SELECT id, titre, contenu, DATE_FORMAT(dateAjout, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM news WHERE id = ?');
        $req->execute(array($postId));
        $post = $req->fetch();
      
        return $post;
    }
}
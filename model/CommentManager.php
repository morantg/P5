<?php

namespace model;

class CommentManager
{
    private $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

  /**
   * Récupère tout les commentaires
   * @return array
   */
    public function allComments()
    {
        $req = $this->db->query('SELECT * from comments');
        $comments = $req->fetchAll();
        return $comments;
    }

  /**
   * Récupère tout les commentaires non publiés
   * @return array
   */
    public function allCommentsUnpublished()
    {
        $req = $this->db->query('SELECT * from comments WHERE publication = 0');
        $comments = $req->fetchAll();
        return $comments;
    }
 
  /**
   * Méthode récupérant tout les commentaires pour une news donnée
   * @param $postId int
   * @return bool
   */
    public function getComments($postId)
    {
        $comments = $this->db->prepare('
          SELECT id, author, comment, 
          DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr 
          FROM comments 
          WHERE post_id = ? 
          AND publication = 1 
          ORDER BY comment_date DESC');
        $comments->execute(array($postId));

        return $comments;
    }

  /**
   * Méthode permettant à un utilisateur de posté un commentaire
   * @param $postId int
   * @param $author string
   * @param $comment string
   * @return bool
   */
    public function postComment($postId, $author, $comment)
    {
        $comments = $this->db->prepare('
          INSERT INTO comments(post_id, author, comment, comment_date) 
          VALUES(?, ?, ?, NOW())');
        $affectedLines = $comments->execute(array($postId, $author, $comment));

        return $affectedLines;
    }

  /**
   * Méthode permettant à l'administrateur de publié les commentaires des utilisateurs
   * @param $ids int
   * @return void
   */
    public function publication($ids)
    {
        foreach ($ids as $id) {
            $req = $this->db->prepare('UPDATE comments SET publication = 1 WHERE id = :id');
            $req->bindValue(':id', $id);
            $req->execute();
        }
    }

  /**
   * Méthode permettant à l'administrateur de supprimés les commentaires d'utilisateurs
   * @param $ids int
   * @return void
   */
    public function deleteComment($ids)
    {
        foreach ($ids as $id) {
            $req = $this->db->prepare('DELETE FROM comments WHERE id = :id');
            $req->bindValue(':id', $id);
            $req->execute();
        }
    }
}

<?php


class CommentManager 
{
    
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function allComments(){
        $req = $this->db->query('SELECT * from comments');
        $comments = $req->fetchAll();
        return $comments;
    }

    public function allCommentsUnpublished(){
        $req = $this->db->query('SELECT * from comments WHERE publication = 0');
        $comments = $req->fetchAll();
        return $comments;
    }

    public function getComments($postId)
    {
        $comments = $this->db->prepare('SELECT id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comments WHERE post_id = ? AND publication = 1 ORDER BY comment_date DESC');
        $comments->execute(array($postId));

        return $comments;
    }

    public function postComment($postId, $author, $comment)
    {
        $comments = $this->db->prepare('INSERT INTO comments(post_id, author, comment, comment_date) VALUES(?, ?, ?, NOW())');
        $affectedLines = $comments->execute(array($postId, $author, $comment));

        return $affectedLines;
    }

    public function publication($ids){
        
        foreach($ids as $id){
            $req = $this->db->prepare('UPDATE comments SET publication = 1 WHERE id = :id');
            $req->bindValue(':id', $id);
            $req->execute();
        }
    }
}
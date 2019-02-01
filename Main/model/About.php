<?php

class About{
	

	private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }


	public function getAbout(){
		$req = $this->db->query('SELECT contenu from about where id = 1');
		$contenu = $req->fetch();
		return $contenu;
	}

	public function editAbout($contenu){
		$req = $this->db->prepare('UPDATE about SET contenu = ? WHERE id = 1');
		$datas = $req->execute(array($contenu));
		return $datas;
	}



}
<?php

class About{
	

	private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

  /**
   * Méthode permettant de récupérer la section a propos
   * @return stdClass La section A propos
   */
	public function getAbout(){
		$req = $this->db->query('SELECT contenu from about where id = 1');
		$contenu = $req->fetch();
		return $contenu;
	}

  /**
   * Méthode permettant d'éditer la section a propos
   * @param $contenu string La section a propos à éditer
   * @return bool
   */
	public function editAbout($contenu){
		$req = $this->db->prepare('UPDATE about SET contenu = ? WHERE id = 1');
		$datas = $req->execute(array($contenu));
		return $datas;
	}



}
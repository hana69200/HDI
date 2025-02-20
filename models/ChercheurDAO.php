<?php

require_once(PATH_MODELS . 'DAO.php');
require_once(PATH_ENTITY . 'Chercheur.php');
require_once(PATH_MODELS . 'PhotoDAO.php');
require_once(PATH_ENTITY . 'Photo.php');

class ChercheurDAO extends DAO {
	
    public function connexion($EMAIL, $PWD) {
		
		$ligne = $this -> queryRow("SELECT * FROM CHERCHEUR WHERE EMAIL = ? AND PWD = ?", array($EMAIL, sha1($PWD)));
		if ($ligne) {
			return new Chercheur($ligne['ID_CHERCHEUR'], $ligne['NOM'], $ligne['PRENOM'], $ligne['PWD'], $ligne['EMAIL']);
		}
		else {
			return false;
        }
	}
	
	public function getById($id)
	{
		$res= $this->queryRow('SELECT * FROM CHERCHEUR WHERE ID_CHERCHEUR=?', array($id));
		if($res ===false)
		{
			$chercheur=null;
		
		}
		else{
			$chercheur=new Chercheur($res['ID_CHERCHEUR'],$res['NOM'],$res['PRENOM'],$res['PWD'],$res['EMAIL'],$res['IDHAL'], $res['ORCID_ID']);
			
		}
		return $chercheur;
	}

	public function getChercheur()
		//retourne un tableau d'image
	{
		$i=0;
		$res = $this->queryAll('select * from CHERCHEUR');
		if($res == false)
			$chercheurs=array();
		else
		{
			foreach($res as $v)
			{
				$chercheurs[$i]= new CHERCHEUR($v['ID_CHERCHEUR'],$v['NOM'],$v['PRENOM'],$v['PWD'],$v['EMAIL'],$v['IDHAL'], $v['ORCID_ID']);
				$i++;
				
			}
			return $chercheurs;
		}
		return null;
	}
    
    public function getUserByUsername($EMAIL) {
		
		$ligne = $this -> queryRow("SELECT * FROM CHERCHEUR WHERE EMAIL = ? ", array($EMAIL));
		if ($ligne) {
			return new Chercheur($ligne['ID_CHERCHEUR'], $ligne['NOM'], $ligne['PRENOM'], $ligne['PWD'], $ligne['EMAIL'], $ligne['IDHAL'], $ligne['ORCID_ID']);
		
		}
		else {
			return false;
        }
    }
    public function getUsernameById($id) {
		
		$ligne = $this -> queryRow("SELECT LOGIN FROM CHERCHEUR WHERE ID_CHERCHEUR = ? ", array($id));
		if ($ligne) {
            return new Chercheur($ligne['ID_CHERCHEUR'], $ligne['NOM'], $ligne['PRENOM'], $ligne['PWD'], $ligne['EMAIL'], $ligne['IDHAL'], $ligne['ORCID_ID']);
		}
		else {
			return false;
        }
	}
	
    
    public function getUserById($id) {
		
		$ligne = $this -> queryRow("SELECT * FROM CHERCHEUR WHERE ID_CHERCHEUR = ?", array($id));
		if ($ligne) {
			return new Chercheur($ligne['ID_CHERCHEUR'], $ligne['NOM'], $ligne['PRENOM'], $ligne['PWD'], $ligne['EMAIL'], $ligne['IDHAL'], $ligne['ORCID_ID']);
		}
		else {
			return false;
        }
    }

    public function creerUser($NOM, $PRENOM, $PWD, $EMAIL)
    {
    	// Récupération d'un identifiant libre
        $res = $this -> queryRow('SELECT MAX(ID_CHERCHEUR) FROM CHERCHEUR');
		$userID = $res['MAX(ID_CHERCHEUR)'] + 1;
		
		// Ajout du VIP en base
		$this -> _requete("INSERT INTO CHERCHEUR (ID_CHERCHEUR, NOM, PRENOM, PWD, EMAIL)
						   VALUES (?, ?, ?,?,?)", array($userID,$NOM, $PRENOM, $PWD, $EMAIL));
		return $userID;
	}
	
	public function recupEmail($email)
	{
		//recuperation de l'email
		$ligne = $this -> queryRow("SELECT * FROM CHERCHEUR WHERE EMAIL = ?", array($email));
		if ($ligne) {
			return new Chercheur($ligne['ID_CHERCHEUR'], $ligne['NOM'], $ligne['PRENOM'], $ligne['PWD'], 
								 $ligne['EMAIL'], $ligne['IDHAL'], $ligne['ORCID_ID']);
		}
		else {
			return false;
        }
	}
	public function modifierChercheur($nom,$prenom,$email,$idhal)
	{
		$id = $_SESSION['id'];
		
		// mettre à jour un chercheur
        $res = $this -> _requete('UPDATE CHERCHEUR 
									 set NOM =?,PRENOM=?,EMAIL=?,IDHAL=? WHERE ID_CHERCHEUR=?', 
									 array($nom,$prenom,$email,$idhal,$id));

	}

	public function updatePwd($pwd)
	{
		$id = $_SESSION['id'];
		$res = $this -> _requete('UPDATE CHERCHEUR set PWD =? WHERE ID_CHERCHEUR=?', array($pwd,$id));
	}
	public function updateOrcid($orcid)
	{
		$id = $_SESSION['id'];
		$res = $this -> _requete('UPDATE CHERCHEUR set ORCID_ID =? WHERE ID_CHERCHEUR=?', array($orcid,$id));
	}

	public function supprimerChercheur($id) 
	{
			// Suppression d'un vip dans la base
			$req = $this->_requete('DELETE FROM CHERCHEUR WHERE ID_CHERCHEUR='.$id);
		
	}

}

?>

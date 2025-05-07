<?php
namespace App\Models;

use CodeIgniter\Model;
use \App\Models\Tools;

/**
 * Modèle qui implémente les fonctions d'accès aux données 
 */
class DataAccess extends Model
{
	// TODO : Transformer toutes les requêtes en requêtes paramétrées

	protected $db;

	function __construct()
	{
		parent::__construct();
		$this->db = \Config\Database::connect();
	}

	/**
	 * Retourne les informations d'un visiteur
	 * 
	 * @param $login 
	 * @return l'id, le nom, le prénom, le login et le mot de passe sous la forme d'un tableau associatif 
	 */
	public function getVisiteur($login)
	{
		$req = "select id, nom, prenom, login, mdp  
						from visiteur 
						where login=?";
		$rs = $this->db->query($req, $login);
		$ligne = $rs->getFirstRow('array');
		return $ligne;
	}

	public function getComptable($login)
	{
		$req = "select id, nom, prenom, login, mdp  
						from comptable
						where login=?";
		$rs = $this->db->query($req, $login);
		$ligne = $rs->getFirstRow('array');
		return $ligne;
	}

	/**
	 * Retourne sous forme d'un tableau associatif toutes les lignes de frais hors forfait
	 * concernées par les deux arguments
	 * La boucle foreach ne peut être utilisée ici car on procède
	 * à une modification de la structure itérée - transformation du champ date-
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	 * @return tous les champs des lignes de frais hors forfait sous la forme d'un tableau associatif 
	 */
	public function getLesLignesHorsForfait($idVisiteur, $mois)
	{

		$req = "select id, idVisiteur, mois, libelle, date, montant 
						from lignefraishorsforfait 
						where lignefraishorsforfait.idvisiteur ='$idVisiteur' 
							and lignefraishorsforfait.mois = '$mois' ";
		$rs = $this->db->query($req);
		$lesLignes = $rs->getResultArray();
		// $nbLignes = count($lesLignes);
		// for ($i=0; $i<$nbLignes; $i++){
		// $date = $lesLignes[$i]['date'];
		// $lesLignes[$i]['date'] =  Tools::dateAnglaisVersFrancais($date);
		// }
		// foreach ($lesLignes as &$uneLigne){
		// $uneLigne['date'] =  Tools::dateAnglaisVersFrancais($uneLigne['date']);
		// }
		return $lesLignes;
	}

	/**
	 * Retourne sous forme d'un tableau associatif toutes les lignes de frais au forfait
	 * concernées par les deux arguments
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	 * @return l'id, le libelle et la quantité sous la forme d'un tableau associatif 
	 */
	public function getLesLignesForfait($idVisiteur, $mois)
	{
		$req = "select fraisforfait.id as idfrais, fraisforfait.libelle as libelle, lignefraisforfait.quantite as quantite 
						from lignefraisforfait inner join fraisforfait 
							on fraisforfait.id = lignefraisforfait.idfraisforfait
						where lignefraisforfait.idvisiteur ='$idVisiteur' and lignefraisforfait.mois='$mois' 
						order by lignefraisforfait.idfraisforfait";
		$rs = $this->db->query($req);
		$lesLignes = $rs->getResultArray();
		return $lesLignes;
	}

	/**
	 * Retourne tous les FraisForfait
	 * 
	 * @return un tableau associatif contenant les fraisForfaits
	 */
	public function getLesFraisForfait()
	{
		$req = "select fraisforfait.id as idfrais, libelle, montant from fraisforfait order by fraisforfait.id";
		$rs = $this->db->query($req);
		$lesLignes = $rs->getResultArray();
		return $lesLignes;
	}

	/**
	 * Met à jour la table ligneFraisForfait pour un visiteur et
	 * un mois donné en enregistrant les nouveaux montants
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	 * @param $lesQtes tableau associatif de clé idFrais et de valeur la quantité pour ce frais
	 */
	public function updateLignesForfait($idVisiteur, $mois, $lesQtes)
	{
		$lesIdFrais = array_keys($lesQtes);
		foreach ($lesIdFrais as $unIdFrais) {
			$qte = $lesQtes[$unIdFrais];
			$req = "update lignefraisforfait 
							set lignefraisforfait.quantite = $qte
							where lignefraisforfait.idvisiteur = '$idVisiteur' 
								and lignefraisforfait.mois = '$mois'
								and lignefraisforfait.idfraisforfait = '$unIdFrais'";
			$this->db->simpleQuery($req);
		}
	}

	/**
	 * Teste si un visiteur possède une fiche de frais pour le mois passé en argument
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	 * @return vrai si la fiche existe, ou faux sinon
	 */
	public function existeFiche($idVisiteur, $mois)
	{
		$ok = false;
		$req = "select count(*) as nblignesfrais 
						from fichefrais 
						where fichefrais.mois = '$mois' and fichefrais.idvisiteur = '$idVisiteur'";
		$rs = $this->db->query($req);
		$laLigne = $rs->getFirstRow('array');
		if ($laLigne['nblignesfrais'] != 0) {
			$ok = true;
		}
		return $ok;
	}

	/**
	 * Crée une nouvelle fiche de frais et les lignes de frais au forfait pour un visiteur et un mois donnés
	 * L'état de la fiche est mis à 'CR'
	 * Les lignes de frais forfait sont affectées de quantités nulles et du montant actuel de FraisForfait
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	 */
	public function insertFiche($idVisiteur, $mois)
	{
		$req = "insert into fichefrais(idvisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat) 
						values('$idVisiteur','$mois',0,0,now(),'CR')";
		$this->db->simpleQuery($req);
		$lesFF = $this->getLesFraisForfait();
		foreach ($lesFF as $uneLigneFF) {
			$unIdFrais = $uneLigneFF['idfrais'];
			$montantU = $uneLigneFF['montant'];
			$req = "insert into lignefraisforfait(idvisiteur,mois,idFraisForfait,quantite, montantApplique) 
							values('$idVisiteur','$mois','$unIdFrais',0, $montantU)";
			$this->db->simpleQuery($req);
		}
	}

	/**
	 * Crée un nouveau frais hors forfait pour un visiteur un mois donné
	 * à partir des informations fournies en paramètre
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	 * @param $libelle : le libelle du frais
	 * @param $date : la date du frais au format français jj//mm/aaaa
	 * @param $montant : le montant
	 */
	public function insertLigneHorsForfait($idVisiteur, $mois, $libelle, $date, $montant)
	{
		$req = "insert into lignefraishorsforfait 
						values('','$idVisiteur','$mois','$libelle','$date','$montant')";
		$this->db->simpleQuery($req);
	}

	/**
	 * Supprime le frais hors forfait dont l'id est passé en argument
	 * 
	 * @param $idFrais 
	 */
	public function deleteLigneHorsForfait($idFrais)
	{
		$req = "delete from lignefraishorsforfait 
						where lignefraishorsforfait.id =$idFrais ";
		$this->db->simpleQuery($req);
	}

	/**
	 * Retourne les informations d'une fiche de frais d'un visiteur pour un mois donné
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	 * @return un tableau avec des champs de jointure entre une fiche de frais et la ligne d'état 
	 */
	public function getLaFiche($idVisiteur, $mois)
	{
		$req = "select ficheFrais.idEtat as idEtat, ficheFrais.dateModif as dateModif, 
							ficheFrais.nbJustificatifs as nbJustificatifs, ficheFrais.montantValide as montantValide, etat.libelle as libEtat 
						from  fichefrais inner join Etat on ficheFrais.idEtat = Etat.id 
						where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$rs = $this->db->query($req);
		$laLigne = $rs->getFirstRow('array');
		return $laLigne;
	}

	/**
	 * Modifie l'état et la date de modification d'une fiche de frais
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	 * @param $etat : le nouvel état de la fiche 
	 */
	public function updateEtatFiche($idVisiteur, $mois, $etat)
	{

		$req = "update fichefrais 
						set idEtat = '$etat', dateModif = now() 
						where fichefrais.idVisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$this->db->simpleQuery($req);
	}
	public function getLesFichesSignees()
	{
		$req = "select idVisiteur, mois, montantValide, dateModif, id, libelle
		from  fichefrais 
		inner join Etat on ficheFrais.idEtat = Etat.id 
		where fichefrais.idEtat = 'CL'
		order by mois desc";
		$rs = $this->db->query($req);
		$lesFiches = $rs->getResultArray();
		return $lesFiches;
	}

	// public function ajouterMotifRefus($idComptable, $mois, $motif)
	// {
	// 	$sql = "UPDATE fichefrais SET commentaireRefus = :motif:, dateModif = NOW() 
    //         WHERE idVisiteur = :idComptable: AND mois = :mois:";

	// 	$this->db->query($sql, [
	// 		'idComptable' => $idComptable,
	// 		'mois' => $mois,
	// 		'motif' => $motif
	// 	]);
	// }
	/**
	 * Obtient toutes les fiches (sans détail) d'un visiteur donné 
	 * 
	 * @param $idVisiteur 
	 */
	public function getLesFiches($idVisiteur)
	{
		$req = "select idVisiteur, mois, montantValide, dateModif, id, libelle
						from  fichefrais inner join Etat on ficheFrais.idEtat = Etat.id 
						where fichefrais.idvisiteur = '$idVisiteur'
						order by mois desc";
		$rs = $this->db->query($req);
		$lesFiches = $rs->getResultArray();
		return $lesFiches;
	}

	/**
	 * Calcule le montant total de la fiche pour un visiteur et un mois donnés
	 * 
	 * @param $idVisiteur 
	 * @param $mois
	 * @return le montant total de la fiche
	 */
	public function calculeTotalFiche($idVisiteur, $mois)
	{
		// obtention du total hors forfait
		$req = "select SUM(montant) as totalHF
						from  lignefraishorsforfait 
						where idvisiteur = '$idVisiteur'
							and mois = '$mois'";
		$rs = $this->db->query($req);
		$laLigne = $rs->getFirstRow('array');
		$totalHF = $laLigne['totalHF'];

		// obtention du total forfaitisé
		$req = "select SUM(montantApplique * quantite) as totalF
						from  lignefraisforfait 
						where idvisiteur = '$idVisiteur'
							and mois = '$mois'";
		$rs = $this->db->query($req);
		$laLigne = $rs->getFirstRow('array');
		$totalF = $laLigne['totalF'];

		return $totalHF + $totalF;
	}

	/**
	 * Modifie le montantValide et la date de modification d'une fiche de frais
	 * 
	 * @param $idVisiteur : l'id du visiteur
	 * @param $mois : mois sous la forme aaaamm
	 */
	public function updateMontantFiche($idVisiteur, $mois)
	{

		$totalFiche = $this->calculeTotalFiche($idVisiteur, $mois);
		$req = "update ficheFrais 
						set montantValide = '$totalFiche', dateModif = now() 
						where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$this->db->simpleQuery($req);
	}
}
?>
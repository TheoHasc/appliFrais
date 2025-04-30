<?php namespace App\Models;

use CodeIgniter\Model;
use \App\Models\DataAccess;
use \DateTime;
use \DateInterval;

/**
 * Modèle représentant tous les traitements possibles attachés à un Visiteur désigné
 *
 */
class ActionsVisiteur extends Model {

	private $dao;
	private $idVisiteur;
	 
	function __construct($idVisiteur)
	{
		// Call the Model constructor
		parent::__construct();

		// chargement du modèle d'accès aux données qui est utile à toutes les méthodes
		$this->dao = new DataAccess();
		$this->idVisiteur = $idVisiteur;
	}

	/**
	 * Mécanisme de contrôle d'existence des fiches de frais sur les 6 derniers 
	 * mois pour un visiteur donné. 
	 * Si l'une d'elle est absente, elle est créée.
	 * 
	*/
	public function checkLastSix()
	{	
		// date courante
		$date = new DateTime ("now");
		// interval de 1 mois
		$interval = new DateInterval('P1M');
		
		// Six tours de boucle
		for($i=1; $i<=6; $i++) {
			// la date au format aaaamm
			$unMois = $date->format('Ym');
			// si la fiche pour le mois concerné n'existe pas, ...
			if(!$this->dao->existeFiche($this->idVisiteur, $unMois)) {
				// ...on la crée
				$this->dao->insertFiche($this->idVisiteur, $unMois);
			}
			// le mois précédent
			$date->sub($interval);
		}
	}
	
	/**
	 * Liste les fiches existantes d'un visiteur 
	 *
	 * @param $message : message facultatif destiné à notifier l'utilisateur du résultat d'une action précédemment exécutée
	*/
	public function getLesFichesDuVisiteur($message=null)
	{		
		return $this->dao->getLesFiches($this->idVisiteur);
	}	

	/**
	 * Retourne le détail de la fiche sélectionnée 
	 * 
	 * @param $mois : le mois de la fiche à modifier 
	*/
	public function getLaFiche($mois)
	{	
		$res = array();
		
		$res['lesFraisHorsForfait'] = $this->dao->getLesLignesHorsForfait($this->idVisiteur, $mois);
		$res['lesFraisForfait'] = $this->dao->getLesLignesForfait($this->idVisiteur, $mois);		
		
		return $res;
	}

	/**
	 * Signe une fiche de frais en modifiant son état de "CR" à "CL"
	 * Ne fait rien si l'état initial n'est pas "CR"
	 * 
	 * @param $mois : le mois de la fiche à signer
	*/
	public function signeLaFiche($mois)
	{	// TODO : intégrer une fonctionnalité d'impression PDF de la fiche

		$laFiche = $this->dao->getLaFiche($this->idVisiteur,$mois);
		if($laFiche['idEtat']=='CR'){
				$this->dao->updateEtatFiche($this->idVisiteur, $mois,'CL');
		}
	}

	/**
	 * Modifie les quantités associées aux frais forfaitisés dans une fiche donnée
	 * 
	 * @param $mois : le mois de la fiche concernée
	 * @param $lesFrais : les quantités liées à chaque type de frais, sous la forme d'un tableau
	*/
	public function updateForfait($mois, $lesQtes)
	{	// TODO : s'assurer que les paramètres reçus sont cohérents avec ceux mémorisés en session
		// TODO : valider les données contenues dans $lesFrais ...
		
		$this->dao->updateLignesForfait($this->idVisiteur,$mois,$lesQtes);
		$this->dao->updateMontantFiche($this->idVisiteur,$mois);
	}

	/**
	 * Ajoute une ligne de frais hors forfait dans une fiche donnée
	 * 
	 * @param $mois : le mois de la fiche concernée
	 * @param $lesFrais : les quantités liées à chaque type de frais, sous la forme d'un tableau
	*/
	public function insertFrais($mois, $uneLigne)
	{	// TODO : s'assurer que les paramètres reçus sont cohérents avec ceux mémorisés en session
		// TODO : valider la donnée contenues dans $uneLigne ...

		$dateFrais = $uneLigne['dateFrais'];
		$libelle = $uneLigne['libelle'];
		$montant = $uneLigne['montant'];

		$this->dao->insertLigneHorsForfait($this->idVisiteur,$mois,$libelle,$dateFrais,$montant);
		$this->dao->updateMontantFiche($this->idVisiteur,$mois);
	}

	/**
	 * Supprime une ligne de frais hors forfait dans une fiche donnée
	 * 
	 * @param $mois : le mois de la fiche concernée
	 * @param $idLigneFrais : l'id de la ligne à supprimer
	*/
	public function deleteFraisHorsForfait($mois, $idLigneFrais)
	{	// TODO : s'assurer que les paramètres reçus sont cohérents avec ceux mémorisés en session et cohérents entre eux

	  $this->dao->deleteLigneHorsForfait($idLigneFrais);
		$this->dao->updateMontantFiche($this->idVisiteur,$mois);
	}
}
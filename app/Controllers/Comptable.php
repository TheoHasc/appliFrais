<?php namespace App\Controllers;

use App\Models\ActionsComptable;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use \App\Models\Authentif;
use \App\Models\ActionsVisiteur;

/**
 * Contrôleur du module Comptable de l'application
 */
class Comptable extends BaseController {

	private $authentif;
	private $idComptable;
	private $idVisiteur;
	private $data;

	private $actComptable;

   
	/**
	 * Constructeur du contrôleur : constructeur fourni par CodeIgniter. S'exécute après le 
	 * constructeur PHP __construct
	 *
	 * Note 1 : Aurait pu être utilisé pour empêcher l'accès aux non-visiteurs mais un constructeur 
	 * 					ne permet pas de renvoyer une vue. Donc pas de vue "erreur" et pas de vue 
	 * 					"connexion" non plus. 
	 * Note 2 : L'interdiction d'accès à ce contrôleur pour les non-visiteurs est opérée par le 
	 * 					biais de "Controller filters" (voir app/Filters/VisiteurFilter.php et 
	 * 					app/Config/Filters.php)
	 */
	public function initController(RequestInterface $request, ResponseInterface $response,
			LoggerInterface $logger ) {
				
		parent::initController($request, $response, $logger);

		// Initialisation des attributs de la classe
		$this->authentif = new Authentif();
		$this->session = session();
		$this->idComptable = $this->session->get('idUser');
		$this->data['identite'] = $this->session->get('prenom').' '.$this->session->get('nom');
		$this->actComptable = new ActionsComptable($this->idComptable);

	}



	/**
	 * Méthode par défaut qui renvoie la page d'acceuil 
	 */
	public function index()
	{
		// envoie de la vue accueil du visiteur
		return view('v_comptableAccueil', $this->data);
	}

	public function lesFiches($message = "")
{
    $this->data['lesFiches'] = $this->actComptable->getLesFichesVisiteurs();
    $this->data['notify'] = $message;

    return view('v_comptableFichesFrais', $this->data);
}


	/**
 * Affiche la liste des fiches de frais à valider
 */
public function voirFichesFrais() {
    // Code pour récupérer les fiches de frais à valider
    $this->data['lesFiches'] = $this->actComptable->getLesFichesVisiteurs();
   

    return view('v_comptableFichesFrais', $this->data);
}

/**
 * Valide une fiche de frais sélectionnée
 */
public function validerFiche($mois,$idVisiteur )
{
    $this->actComptable->validerFicheFrais($mois, $idVisiteur);
    return $this->lesFiches("La fiche $mois du visiteur $idVisiteur a été validée.");
}

public function refuserFiche($mois, $idVisiteur)
{
    $motif = $this->request->getPost('motif');
    if (empty($motif)) {
        return $this->lesFiches("Veuillez fournir un motif pour refuser la fiche.");
    }
    $this->actComptable->refuserFicheFrais($mois, $idVisiteur, $motif);
    return $this->lesFiches("La fiche $mois du visiteur $idVisiteur a été refusée. Motif : $motif");
}

	/**
	 * Déconnecte la session
	 */
	public function seDeconnecter()	
	{
		return $this->authentif->deconnecter();
	}

	
}
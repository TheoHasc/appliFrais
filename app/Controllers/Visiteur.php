<?php namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use \App\Models\Authentif;
use \App\Models\ActionsVisiteur;

/**
 * Contrôleur du module VISITEUR de l'application
 */
class Visiteur extends BaseController {

	private $authentif;
	private $idVisiteur;
	private $data;
	private $actVisiteur;
   
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
		$this->idVisiteur = $this->session->get('idUser');
		$this->data['identite'] = $this->session->get('prenom').' '.$this->session->get('nom');
		$this->actVisiteur = new ActionsVisiteur($this->idVisiteur);

		// Vérification de la présence des 6 dernières fiches de frais pour le visiteur connecté
		$this->actVisiteur->checkLastSix();
	}

	/**
	 * Méthode par défaut qui renvoie la page d'acceuil 
	 */
	public function index()
	{
		// envoie de la vue accueil du visiteur
		return view('v_visiteurAccueil', $this->data);
	}

	/**
	 * Restitue les liste des fiches du visiteur connecté, sans détails
	 */ 
	public function  mesFiches($message = "")
	{
		log_message('debug', 'Entrée dans getLesFichesVisiteurs');

		$this->data['mesFiches'] = $this->actVisiteur->getLesFichesDuVisiteur();
		$this->data['notify'] = $message;

		return view('v_visiteurMesFiches', $this->data);	
	}

	/**
	 * Déconnecte la session
	 */
	public function seDeconnecter()	
	{
		return $this->authentif->deconnecter();
	}

	/**
	 * Affiche le détail d'une fiche de frais du visiteur connecté, en lecture seule
	 *
	 * @param : le mois de la fiche concernée
	 */
	public function voirMaFiche($mois)
	{	// TODO : contrôler la validité du mois de la fiche à consulter
	
		$this->data['fiche'] = $this->actVisiteur->getLaFiche($mois);
		$this->data['mois'] = $mois;
		return view('v_visiteurVoirFiche', $this->data);
	}

	/**
	 * Affiche le détail d'une fiche de frais du visiteur connecté, en mode modification
	 *
	 * @param $mois le mois de la fiche concernée
	 * @param $message message de confirmation lorsque des modification ont été enregistrées
	 */	
	public function modMaFiche($mois, $message = "")
	{	// TODO : contrôler la validité du mois de la fiche à modifier
	
		$this->data['notify'] = $message;
		$this->data['mois'] = $mois;
		$this->data['fiche'] = $this->actVisiteur->getLaFiche($mois);
		
		return view('v_visiteurModFiche', $this->data);
	}

	/**
	 * Signe la fiche du visiteur connecté
	 *
	 * @param $mois le mois de la fiche concernée
	 */
	public function signeMaFiche($mois)
	{	// TODO : contrôler la validité du mois de la fiche à modifier

		$this->actVisiteur->signeLaFiche($mois);
		// ... et on revient à mesFiches
		return $this->mesFiches("La fiche $mois a été signée. <br/>Pensez à envoyer vos justificatifs afin qu'elle soit traitée par le service comptable rapidement.");
	}

	/**
	 * Traitement de la soumission du formulaire de mise à jour des quantités de 
	 * frais forfaitisés pour la fiche du visiteur connecté. Les données à jour sont
	 * transmises en POST.
	 *
	 * @param $mois le mois de la fiche concernée
	 */
	public function updateForfait($mois)
	{	// TODO : dans la dynamique de l'application, contrôler que l'on vient bien de modFiche
		
		// obtention des données transmises
		$lesQtes = $this->request->getPost('lesQtes');
		$this->actVisiteur->updateForfait($mois, $lesQtes);
		// ... et on revient en modification de la fiche
		return $this->modMaFiche($mois, 'Modification(s) des éléments forfaitisés enregistrée(s) ...');
	}
	
	/**
	 * Traitement de la soumission du formulaire permettant l'ajout d'une ligne de  
	 * frais hors forfait pour la fiche du visiteur connecté. Les données utiles sont
	 * transmises en POST.
	 *
	 * @param $mois le mois de la fiche concernée
	 */
	public function ajouteUneLigneDeFrais($mois)
	{	// TODO : dans la dynamique de l'application, contrôler que l'on vient bien de modFiche
		
		// obtention des données postées
		$uneLigne = array( 
			'dateFrais' => $this->request->getPost('dateFrais'),
			'libelle' => $this->request->getPost('libelle'),
			'montant' => $this->request->getPost('montant')
		);
		$this->actVisiteur->insertFrais($mois, $uneLigne);
		// ... et on revient en modification de la fiche
		return $this->modMaFiche($mois, 'Ligne "Hors forfait" ajoutée ...');				
	}
	
	/**
	 * Traitement de la soumission du formulaire de suppression d'une ligne de  
	 * frais hors forfait pour la fiche du visiteur connecté. 
	 *
	 * @param $mois le mois de la fiche concernée
	 * @param $idLigneFrais l'identifiant relatif de la ligne à supprimer
	 */
	public function deleteUneLigneDeFrais($mois, $idLigneFrais)
	{	// TODO : contrôler la validité du n° de ligne de frais à supprimer
		// TODO : dans la dynamique de l'application, contrôler que l'on vient bien de modFiche
	
		// l'id de la ligne à supprimer doit avoir été transmis en second paramètre
		$this->actVisiteur->deleteFraisHorsForfait($mois, $idLigneFrais);
		// ... et on revient en modification de la fiche
		return $this->modMaFiche($mois, 'Ligne "Hors forfait" supprimée ...');				
	}
}
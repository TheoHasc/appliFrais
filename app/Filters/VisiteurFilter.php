<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use \App\Models\Authentif;
use \App\Models\ActionsVisiteur;

/**
 * Filtre de contrôleur destiné au contrôleur Visiteur.
 *
 * L'attachement de ce traitement au contrôleur Visiteur est réalisé dans le fichier 
 * app/Config/Filters.php (lignes 15, 29 et 109)
 */
class VisiteurFilter implements FilterInterface
{
	/**
	 * Traitement événementiel AVANT l'accès à une ressource Visiteur.
	 * Ici, il s'agit de vérifier, avant chaque accès au contrôleur Visiteur, que l'utilisateur est 
	 * authentifié comme Visiteur. Si ce n'est pas le cas, la demande d'accès est réacheminée vers 
	 * le contrôleur Anonyme.
	 *
	 */
	public function before(RequestInterface $request, $arguments = null)
	{
		$auth = new Authentif();

		if (! $auth->estVisiteur()) {
			return redirect()->to('/anonyme');
		}
	}

	// Fonction non implémentée
	public function after(RequestInterface $request,  ResponseInterface $response, $arguments = null)
	{
	}
}
<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use \DateTimeImmutable;
use \DateInterval;

class FicheFraisSeeder extends Seeder
{
	public function run()
	{
		// interval d'historique
		$startInterval = new DateInterval('P12M');

		// interval de 1 mois
		$interval = new DateInterval('P1M');

		// Obtention de tous les Visiteurs présents en BdD
		$lesVisiteurs = $this->db->table('visiteur')->get()->getResultArray();

		// Positionnenment de la période d'historique à créer
		$moisActuel = new DateTimeImmutable("now");
		$moisDebut = new DateTimeImmutable($moisActuel->sub($startInterval)->format('Y-m-d'));

		$moisFin = $moisActuel->sub($interval);
		// Parcours des Visiteurs
		foreach($lesVisiteurs as $unVisiteur)
		{
			$idVisiteur = $unVisiteur['id'];

			$moisCourant = $moisFin;
			$n = 1;
			// Parcours de l'historique à créer, à reculons
			while($moisCourant >= $moisDebut)
			{
				// La première fiche (la + récente) est arbitrairement en état CR.
				if($n == 1)
				{
					$etat = "CR";
					$moisModif = $moisCourant;
				}
				else
				{
					// la seconde est arbitrairement en état VA.
					if($n == 2)
					{
						$etat = "VA";
						$moisModif = $moisCourant->add($interval);
					}
					// toutes les autres fiches sont arbitrairement en état RB. 
					else
					{
						$etat = "RB";
						$moisModif = $moisCourant->add($interval)->add($interval);
					}
				}
				// La date de modification de la fiche est calculée selon l'état de la fiche. 
				$dateModif = $moisModif->format('Y-m')."-".rand(1,8);
				// nombre de justificatifs aléatoire 
				$nbJustificatifs = rand(0,12);
				
				// Assemblage de la fiche à mémoriser
				$data = [
					'idvisiteur' 			=> $idVisiteur,
					'mois'						=> $moisCourant->format('Ym'),
					'nbJustificatifs' => $nbJustificatifs,
					'montantValide'		=> 0,
					'dateModif'				=> $dateModif,
					'idEtat'					=> $etat,
				]; 
				
				// Insertion de la fiche dans la table
				$this->db->table('fichefrais')->insert($data);    
				echo '.';

				// On remonte le temps de mois en mois
				$moisCourant = $moisCourant->sub($interval);
				$n++;
			}
		}
	echo "\n";
	}
}

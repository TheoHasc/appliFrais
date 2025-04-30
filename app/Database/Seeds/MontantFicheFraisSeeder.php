<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MontantFicheFraisSeeder extends Seeder
{
	public function run()
	{
		// Obtention de toutes les fiches
		$lesFichesFrais = $this->db->table('fichefrais')->get()->getResultArray();

		// Parcours des fiches
		foreach($lesFichesFrais as $uneFicheFrais)
		{
			// Obtention de la PK de la fiche
			$idVisiteur = $uneFicheFrais['idVisiteur'];
			$mois =  $uneFicheFrais['mois'];

			// Calcul du total des frais hors forfait pour cette fiche
			$ligne = $this->db->table('ligneFraisHorsForfait')
								->where('idvisiteur', $idVisiteur)
								->where('mois', $mois)
								->selectSum('montant', 'total')
								->get()
								->getRowArray();
			$totalMontantHorsForfait = $ligne['total'];
			
			// Calcul du total des frais au forfait pour cette fiche
			$ligne = $this->db->table('ligneFraisForfait')
								->where('idvisiteur', $idVisiteur)
								->where('mois', $mois)
								->selectSum('(quantite * montantApplique)', 'total')
								->get()
								->getRowArray();
			$totalMontantForfait = $ligne['total'];

			// Calcul du total engagé
			$montantEngage = $totalMontantHorsForfait + $totalMontantForfait;

			// Mise à jour du montant total de la fiche dans la table
			$this->db->table('fichefrais')
								->where('idvisiteur', $idVisiteur)
								->where('mois', $mois)
								->set(['montantValide' => $montantEngage])
								->update();    
			echo '.';
		}
		echo "\n";
	}
}

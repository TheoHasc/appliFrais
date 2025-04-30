<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LigneFraisForfaitSeeder extends Seeder
{
	public function run()
	{
		// Obtention de toutes les fiches
		$lesFichesFrais = $this->db->table('fichefrais')->get()->getResultArray();

		// Obtention de tous les frais forfaitisés
		$lesFraisForfait = $this->db->table('fraisforfait')->orderBy('id')->get()->getResultArray();

		// Parcours des fiches
		foreach($lesFichesFrais as $uneFicheFrais)
		{
			// Obtention de la PK de la fiche
			$idVisiteur = $uneFicheFrais['idVisiteur'];
			$mois =  $uneFicheFrais['mois'];

			// Parcours des frais forfaitisés
			foreach($lesFraisForfait as $unFraisForfait)
			{
				// Valorisation aléatoire de la quantité selon le type
				$idFraisForfait = $unFraisForfait['id'];
				if($idFraisForfait == "KM")
				{
					$quantite = rand(100,500);
				}
				else
				{
					$quantite = rand(1,10);
				}
				$montantApp = $unFraisForfait['montant'];

				// Assemblage du frais à mémoriser
				$data = [
					'idvisiteur' 				=> $idVisiteur,
					'mois'							=> $mois,
					'idfraisforfait' 		=> $idFraisForfait,
					'quantite'					=> $quantite,
					'montantApplique'		=> $montantApp,
				]; 
				
				// Insertion du frais dans la table
				$this->db->table('lignefraisforfait')->insert($data);
				echo '.';
			}
		}
		echo "\n";
	}		
}
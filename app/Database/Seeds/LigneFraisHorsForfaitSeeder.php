<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LigneFraisHorsForfaitSeeder extends Seeder
{
	public function run()
	{
		// Définition d'un ensemble de frais-type
		$desFrais = array(
			1 => [ "lib" => "repas avec praticien", "min" => 50, "max" => 150 ],
			2 => [ "lib" => "achat de matériel de papèterie", "min" => 10, "max" => 50 ],
			3	=> [ "lib" => "taxi", "min" => 20, "max" => 80 ],
			4 => [ "lib" => "achat d'espace publicitaire", "min" => 20, "max" => 150 ],
			5 => [ "lib" => "location salle conférence", "min" => 120, "max" => 650 ],
			6 => [ "lib" => "Voyage SNCF", "min" => 30, "max" => 150 ],
			7 => [ "lib" => "traiteur, alimentation, boisson", "min" => 25, "max" => 450 ],
			8 => [ "lib" => "rémunération intervenant/spécialiste", "min" => 250, "max" => 1200 ],
			9 => [ "lib" => "location équipement vidéo/sonore", "min" => 100, "max" => 850 ],
			10 => ["lib" => "location véhicule", "min" => 25, "max" => 450 ],
			11 => [ "lib" => "frais vestimentaire/représentation", "min" => 25, "max" => 450 ] 
		);

		// Obtention de toutes les fiches
		$lesFichesFrais = $this->db->table('fichefrais')->get()->getResultArray();

		// Parcours des fiches
		foreach($lesFichesFrais as $uneFicheFrais)
		{
			// Obtention de la PK de la fiche
			$idVisiteur = $uneFicheFrais['idVisiteur'];
			$mois =  $uneFicheFrais['mois'];
			
			// Calcul aléatoire d'un nombre de frais à créer
			$nbFrais = rand(0,5);
			
			// Fabrication des frais un à un
			for($i=0 ; $i <= $nbFrais ; $i++)
			{
				// choix aléatoire du frais-type et des caractéristiques qui en découlent
				$hasardNumfrais = rand(1,count($desFrais)); 
				$frais = $desFrais[$hasardNumfrais];
				$lib = $frais['lib'];
				$min= $frais['min'];
				$max = $frais['max'];
				$montant = rand($min,$max);
				$numAnnee =substr( $mois,0,4);
				$numMois =substr( $mois,4,2);
				$numJour = rand(1,28);
				// if(strlen($hasardJour)==1)
				// {
					// $hasardJour="0".$hasardJour;
				// }
				$dateFrais = $numAnnee."-".$numMois."-".$numJour;

				// Assemblage du frais à mémoriser
				$data = [
					'idvisiteur' 	=> $idVisiteur,
					'mois'				=> $mois,
					'libelle' 		=> $lib,
					'date'				=> $dateFrais,
					'montant'			=> $montant,
				]; 
				
				// Insertion du frais dans la table
				$this->db->table('lignefraishorsforfait')->insert($data);    
				echo '.';
			}
		}
		echo "\n";
	}
}

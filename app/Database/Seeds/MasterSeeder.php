<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MasterSeeder extends Seeder
{
	public function run()
	{
		// Tables de référence
		$this->call('EtatSeeder');
		$this->call('FraisForfaitSeeder');

		// Jeu d'utilisateurs fictif
		$this->call('VisiteurSeeder');
		
		// Jeu d'essai aléatoire
		$this->call('FicheFraisSeeder');
		$this->call('LigneFraisHorsForfaitSeeder');
		$this->call('LigneFraisForfaitSeeder');
		$this->call('MontantFicheFraisSeeder');
	}
}

<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EtatSeeder extends Seeder
{
	public function run()
	{
		$data = ['id' => 'RB', 'libelle' => 'Remboursée', ];
		$this->db->table('etat')->insert($data);    

		$data = ['id' => 'CL', 'libelle' => 'Fiche Signée, saisie clôturée', ];
		$this->db->table('etat')->insert($data);    

		$data = ['id' => 'CR', 'libelle' => 'Fiche créée, saisie en cours', ];
		$this->db->table('etat')->insert($data);    

		$data = ['id' => 'VA', 'libelle' => 'Validée', ];
		$this->db->table('etat')->insert($data);    

		$data = ['id' => 'MP', 'libelle' => 'Mise en paiement', ];
		$this->db->table('etat')->insert($data);    
	}
}

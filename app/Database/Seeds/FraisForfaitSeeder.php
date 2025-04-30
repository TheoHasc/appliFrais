<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FraisForfaitSeeder extends Seeder
{
    public function run()
    {
			$data = ['id' => 'ETP', 'libelle' => 'Forfait Etape', 'montant' => 130.00, ];
			$this->db->table('fraisforfait')->insert($data);    

			$data = ['id' => 'KM', 'libelle' => 'Frais Kilométrique', 'montant' => 0.62, ];
			$this->db->table('fraisforfait')->insert($data);    

			$data = ['id' => 'NUI', 'libelle' => 'Nuitée Hôtel', 'montant' => 90.00, ];
			$this->db->table('fraisforfait')->insert($data);    

			$data = ['id' => 'REP', 'libelle' => 'Repas Restaurant', 'montant' => 25.00, ];
			$this->db->table('fraisforfait')->insert($data);    

		}
}

<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class VisiteurSeeder extends Seeder
{
	public function run()
	{
		$data = ['id' => 'a131', 'nom' => 'Villachane', 'prenom' => 'Louis', 'login' => 'lvillachane', 'mdp' => 'jux7g', 'adresse' => '8 rue des Charmes', 'cp' => '46000', 'ville' => 'Cahors', 'dateEmbauche' => '2005-12-21', ];
		$this->db->table('visiteur')->insert($data);    

		$data = ['id' => 'a17', 'nom' => 'Andre', 'prenom' => 'David', 'login' => 'dandre', 'mdp' => 'oppg5', 'adresse' => '1 rue Petit', 'cp' => '46200', 'ville' => 'Lalbenque', 'dateEmbauche' => '1998-11-23', ];
		$this->db->table('visiteur')->insert($data);    

		$data = ['id' => 'a55', 'nom' => 'Bedos', 'prenom' => 'Christian', 'login' => 'cbedos', 'mdp' => 'gmhxd', 'adresse' => '1 rue Peranud', 'cp' => '46250', 'ville' => 'Montcuq', 'dateEmbauche' => '1995-01-12', ];
		$this->db->table('visiteur')->insert($data);    

		$data = ['id' => 'a93', 'nom' => 'Tusseau', 'prenom' => 'Louis', 'login' => 'ltusseau', 'mdp' => 'ktp3s', 'adresse' => '22 rue des Ternes', 'cp' => '46123', 'ville' => 'Gramat', 'dateEmbauche' => '2000-05-01', ];
		$this->db->table('visiteur')->insert($data);    

		$data = ['id' => 'b13', 'nom' => 'Bentot', 'prenom' => 'Pascal', 'login' => 'pbentot', 'mdp' => 'doyw1', 'adresse' => '11 allée des Cerises', 'cp' => '46512', 'ville' => 'Bessines', 'dateEmbauche' => '1992-07-09', ];
		$this->db->table('visiteur')->insert($data);    

		$data = ['id' => 'b16', 'nom' => 'Bioret', 'prenom' => 'Luc', 'login' => 'lbioret', 'mdp' => 'hrjfs', 'adresse' => '1 Avenue gambetta', 'cp' => '46000', 'ville' => 'Cahors', 'dateEmbauche' => '1998-05-11', ];
		$this->db->table('visiteur')->insert($data);    

		$data = ['id' => 'b19', 'nom' => 'Bunisset', 'prenom' => 'Francis', 'login' => 'fbunisset', 'mdp' => '4vbnd', 'adresse' => '10 rue des Perles', 'cp' => '93100', 'ville' => 'Montreuil', 'dateEmbauche' => '1987-10-21', ];
		$this->db->table('visiteur')->insert($data);    

		$data = ['id' => 'b25', 'nom' => 'Bunisset', 'prenom' => 'Denise', 'login' => 'dbunisset', 'mdp' => 's1y1r', 'adresse' => '23 rue Manin', 'cp' => '75019', 'ville' => 'paris', 'dateEmbauche' => '2010-12-05', ];
		$this->db->table('visiteur')->insert($data);    

		$data = ['id' => 'b28', 'nom' => 'Cacheux', 'prenom' => 'Bernard', 'login' => 'bcacheux', 'mdp' => 'uf7r3', 'adresse' => '114 rue Blanche', 'cp' => '75017', 'ville' => 'Paris', 'dateEmbauche' => '2009-11-12', ];
		$this->db->table('visiteur')->insert($data);    

		$data = ['id' => 'b34', 'nom' => 'Cadic', 'prenom' => 'Eric', 'login' => 'ecadic', 'mdp' => '6u8dc', 'adresse' => '123 avenue de la République', 'cp' => '75011', 'ville' => 'Paris', 'dateEmbauche' => '2008-09-23', ];
		$this->db->table('visiteur')->insert($data);    

		$data = ['id' => 'b4', 'nom' => 'Charoze', 'prenom' => 'Catherine', 'login' => 'ccharoze', 'mdp' => 'u817o', 'adresse' => '100 rue Petit', 'cp' => '75019', 'ville' => 'Paris', 'dateEmbauche' => '2005-11-12', ];
		$this->db->table('visiteur')->insert($data);    

		$data = ['id' => 'b50', 'nom' => 'Clepkens', 'prenom' => 'Christophe', 'login' => 'cclepkens', 'mdp' => 'bw1us', 'adresse' => '12 allée des Anges', 'cp' => '93230', 'ville' => 'Romainville', 'dateEmbauche' => '2003-08-11', ];
		$this->db->table('visiteur')->insert($data);    

		$data = ['id' => 'b59', 'nom' => 'Cottin', 'prenom' => 'Vincenne', 'login' => 'vcottin', 'mdp' => '2hoh9', 'adresse' => '36 rue Des Roches', 'cp' => '93100', 'ville' => 'Monteuil', 'dateEmbauche' => '2001-11-18', ];
		$this->db->table('visiteur')->insert($data);    

		$data = ['id' => 'c14', 'nom' => 'Daburon', 'prenom' => 'François', 'login' => 'fdaburon', 'mdp' => '7oqpv', 'adresse' => '13 rue de Chanzy', 'cp' => '94000', 'ville' => 'Créteil', 'dateEmbauche' => '2002-02-11', ];
		$this->db->table('visiteur')->insert($data);    

		$data = ['id' => 'c3', 'nom' => 'De', 'prenom' => 'Philippe', 'login' => 'pde', 'mdp' => 'gk9kx', 'adresse' => '13 rue Barthes', 'cp' => '94000', 'ville' => 'Créteil', 'dateEmbauche' => '2010-12-14', ];
		$this->db->table('visiteur')->insert($data);    

		$data = ['id' => 'c54', 'nom' => 'Debelle', 'prenom' => 'Michel', 'login' => 'mdebelle', 'mdp' => 'od5rt', 'adresse' => '181 avenue Barbusse', 'cp' => '93210', 'ville' => 'Rosny', 'dateEmbauche' => '2006-11-23', ];
		$this->db->table('visiteur')->insert($data);    

		$data = ['id' => 'd13', 'nom' => 'Debelle', 'prenom' => 'Jeanne', 'login' => 'jdebelle', 'mdp' => 'nvwqq', 'adresse' => '134 allée des Joncs', 'cp' => '44000', 'ville' => 'Nantes', 'dateEmbauche' => '2000-05-11', ];
		$this->db->table('visiteur')->insert($data);    

		$data = ['id' => 'd51', 'nom' => 'Debroise', 'prenom' => 'Michel', 'login' => 'mdebroise', 'mdp' => 'sghkb', 'adresse' => '2 Bld Jourdain', 'cp' => '44000', 'ville' => 'Nantes', 'dateEmbauche' => '2001-04-17', ];
		$this->db->table('visiteur')->insert($data);    

		$data = ['id' => 'e22', 'nom' => 'Desmarquest', 'prenom' => 'Nathalie', 'login' => 'ndesmarquest', 'mdp' => 'f1fob', 'adresse' => '14 Place d Arc', 'cp' => '45000', 'ville' => 'Orléans', 'dateEmbauche' => '2005-11-12', ];
		$this->db->table('visiteur')->insert($data);    

		$data = ['id' => 'e24', 'nom' => 'Desnost', 'prenom' => 'Pierre', 'login' => 'pdesnost', 'mdp' => '4k2o5', 'adresse' => '16 avenue des Cèdres', 'cp' => '23200', 'ville' => 'Guéret', 'dateEmbauche' => '2001-02-05', ];
		$this->db->table('visiteur')->insert($data);    

		$data = ['id' => 'e39', 'nom' => 'Dudouit', 'prenom' => 'Frédéric', 'login' => 'fdudouit', 'mdp' => '44im8', 'adresse' => '18 rue de l église', 'cp' => '23120', 'ville' => 'GrandBourg', 'dateEmbauche' => '2000-08-01', ];
		$this->db->table('visiteur')->insert($data);    

		$data = ['id' => 'e49', 'nom' => 'Duncombe', 'prenom' => 'Claude', 'login' => 'cduncombe', 'mdp' => 'qf77j', 'adresse' => '19 rue de la tour', 'cp' => '23100', 'ville' => 'La souteraine', 'dateEmbauche' => '1987-10-10', ];
		$this->db->table('visiteur')->insert($data);    

		$data = ['id' => 'e5', 'nom' => 'Enault-Pascreau', 'prenom' => 'Céline', 'login' => 'cenault', 'mdp' => 'y2qdu', 'adresse' => '25 place de la gare', 'cp' => '23200', 'ville' => 'Gueret', 'dateEmbauche' => '1995-09-01', ];
		$this->db->table('visiteur')->insert($data);    

		$data = ['id' => 'e52', 'nom' => 'Eynde', 'prenom' => 'Valérie', 'login' => 'veynde', 'mdp' => 'i7sn3', 'adresse' => '3 Grand Place', 'cp' => '13015', 'ville' => 'Marseille', 'dateEmbauche' => '1999-11-01', ];
		$this->db->table('visiteur')->insert($data);    

		$data = ['id' => 'f21', 'nom' => 'Finck', 'prenom' => 'Jacques', 'login' => 'jfinck', 'mdp' => 'mpb3t', 'adresse' => '10 avenue du Prado', 'cp' => '13002', 'ville' => 'Marseille', 'dateEmbauche' => '2001-11-10', ];
		$this->db->table('visiteur')->insert($data);    

		$data = ['id' => 'f39', 'nom' => 'Frémont', 'prenom' => 'Fernande', 'login' => 'ffremont', 'mdp' => 'xs5tq', 'adresse' => '4 route de la mer', 'cp' => '13012', 'ville' => 'Allauh', 'dateEmbauche' => '1998-10-01', ];
		$this->db->table('visiteur')->insert($data);    

		$data = ['id' => 'f4', 'nom' => 'Gest', 'prenom' => 'Alain', 'login' => 'agest', 'mdp' => 'dywvt', 'adresse' => '30 avenue de la mer', 'cp' => '13025', 'ville' => 'Berre', 'dateEmbauche' => '1985-11-01', ];
		$this->db->table('visiteur')->insert($data);    

	}
}

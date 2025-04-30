<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 *	
 * Pré-requis : la base de données est considérée comme existante et CodeIgniter paramétré pour y accéder
 */
class InitialDB extends Migration
{
    public function up()
    {
		$tables_attributes = [
			'ENGINE' 				=> 'InnoDB',
			'CHARACTER SET'	=> 'utf8mb4',
			'COLLATE'				=> 'utf8mb4_general_ci',
		];

		/*
			TABLE : fraisforfait 
		*/
		$fields = [
			'id'				=> [ 'type'	=> 'CHAR', 'constraint'	=> 3, ],
			'libelle'		=> [ 'type' => 'VARCHAR', 'constraint' => 20, ],
			'montant'		=> [ 'type' => 'DECIMAL', 'constraint' => '5,2', ],
		];

		$this->forge->addField($fields);
		$this->forge->addPrimaryKey('id');
		$this->forge->createTable('fraisforfait', true, $tables_attributes);

		/*
			TABLE : etat 
		*/
		$fields = [ 
			'id'				=> [ 'type' => 'CHAR', 'constraint' => 2, ],
			'libelle'		=> [ 'type' => 'VARCHAR', 'constraint'	=> 30, ],
		];

		$this->forge->addField($fields);
		$this->forge->addPrimaryKey('id');
		$this->forge->createTable('etat', true, $tables_attributes);

		/*
			TABLE : visiteur 
		*/
		$fields = [
			'id'						=> [ 'type' => 'CHAR', 'constraint' => 4, ],
			'nom'						=> [ 'type' => 'VARCHAR', 'constraint'	=> 30, ],
			'prenom'				=> [ 'type' => 'VARCHAR', 'constraint'	=> 30, ],
			'login'					=> [ 'type' => 'VARCHAR', 'constraint'	=> 20, ],
			'mdp'						=> [ 'type'	=> 'VARCHAR', 'constraint'	=> 20, ],
			'adresse'				=> [ 'type' => 'VARCHAR', 'constraint'	=> 50, 'null' => true, 'default' => null, ],
			'cp'						=> [ 'type'	=> 'CHAR', 'constraint'	=> 5, 'null' => true, 'default' => null, ],
			'ville'					=> [ 'type'	=> 'VARCHAR', 'constraint' => 30, 'null' => true, 'default' => null, ],
			'dateEmbauche'	=> [ 'type' => 'DATE', 'null' => true, 'default'	=> null, ],
		];

		$this->forge->addField($fields);
		$this->forge->addUniqueKey('login');
		$this->forge->addPrimaryKey('id');
		$this->forge->createTable('visiteur', true, $tables_attributes);

		/*
			TABLE : fichefrais 
		*/
		$fields = [
			'idVisiteur'			=>	[ 'type' => 'CHAR', 'constraint'	=> 4, ],
			'mois'						=>	[ 'type' => 'CHAR', 'constraint'	=> 6, ],
			'nbJustificatifs'	=>	[ 'type' => 'INT', 'constraint'	=> 11, 'null' => true, 'default' => null, ],
			'montantValide' 	=>	[ 'type' => 'DECIMAL', 'constraint'	=> '10, 2', 'null' => true, 'default' => null, ],
			'dateModif' 			=>	[ 'type' => 'DATE', 'null' => true, 'default' => null, ],
			'idEtat' 					=>	[ 'type' => 'CHAR', 'constraint' => 2, 'default' => 'CR', ],
		];

		$this->forge->addField($fields);
		$this->forge->addForeignKey('idEtat', 'Etat', 'id');
		$this->forge->addForeignKey('idVisiteur', 'Visiteur', 'id');
		$this->forge->addPrimaryKey(['idVisiteur', 'mois']);
		$this->forge->createTable('fichefrais', true, $tables_attributes);

		/*
			TABLE : lignefraisforfait 
		*/
		$fields = [
			'idVisiteur'			=>	[ 'type' => 'CHAR', 'constraint'	=> 4, ],
			'mois'						=>	[ 'type' => 'CHAR', 'constraint'	=> 6, ],
			'idFraisForfait'	=>	[ 'type' => 'CHAR', 'constraint'	=> 3, ],
			'quantite' 				=>	[ 'type' => 'INT', 'constraint'	=> 11, 'null' => true, 'default' => null, ],
			'montantApplique' =>	[ 'type' => 'DECIMAL',  'constraint'	=> '5, 2', ],
		];

		$this->forge->addField($fields);
		$this->forge->addForeignKey(['idVisiteur', 'mois'], 'FicheFrais', ['idVisiteur', 'mois']);
		$this->forge->addForeignKey('idFraisForfait', 'fraisforfait', 'id');
		$this->forge->addPrimaryKey(['idVisiteur', 'mois', 'idFraisForfait']);
		$this->forge->createTable('lignefraisforfait', true, $tables_attributes);

		/*
			TABLE : lignefraishorsforfait 
		*/
		$fields = [
			'id'					=>	[ 'type' => 'INT', 'constraint'	=> 11, 'auto_increment' => true, ],
			'idVisiteur'	=>	[ 'type' => 'CHAR', 'constraint' => 4, ],
			'mois'				=>	[ 'type' => 'CHAR', 'constraint' => 6, ],
			'libelle'			=>	[ 'type' => 'VARCHAR', 'constraint'	=> 100, ],
			'date' 				=>	[ 'type' => 'DATE', ],
			'montant' 		=>	[ 'type' => 'DECIMAL', 'constraint'	=> '10, 2', ],
		];

		$this->forge->addField($fields);
		$this->forge->addForeignKey(['idVisiteur', 'mois'], 'FicheFrais', ['idVisiteur', 'mois']);
		$this->forge->addPrimaryKey('id');
		$this->forge->createTable('lignefraishorsforfait', true, $tables_attributes);
    }

    public function down()
    {
		/* 
			TABLE : lignefraishorsforfait 
		*/
		$this->forge->dropTable('lignefraishorsforfait', true);
		/* 
			TABLE : lignefraisforfait 
		*/
		$this->forge->dropTable('lignefraisforfait', true);
		/* 
			TABLE : fichefrais 
		*/
		$this->forge->dropTable('fichefrais', true);
		/* 
			TABLE : visiteur 
		*/
		$this->forge->dropTable('visiteur', true);
		/* 
			TABLE : etat 
		*/
		$this->forge->dropTable('etat', true);
		/* 
			TABLE : fraisforfait 
		*/
		$this->forge->dropTable('fraisforfait', true);
   }
}

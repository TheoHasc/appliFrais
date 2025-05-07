<?= $this->extend('l_comptable') ?>

<?= $this->section('body') ?>
<div id="contenu">
	<h2>Liste des fiches de frais</h2>

	<?php if (!empty($notify))
		echo '<p id="notify">' . $notify . '</p>'; ?>

	<table class="listeLegere">
		<thead>
			<tr>
				<th>Identifiant</th>
				<th>Mois</th>
				<th>Nom</th>
				<th>Montant</th>
				<th>Date modif.</th>
				<th colspan="2">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($lesFiches as $uneFiche) {
				// Correction de la date si elle est en format string (ex: '2024-03-15')
				$dateModif = date_create($uneFiche['dateModif']);
				$formattedDate = $dateModif ? $dateModif->format('d/m/Y') : 'N/A';

				$valLink = '';
				$refLink = '';

				// Vérifie si la fiche peut être validée ou refusée (modifier la condition si besoin)
				if ($uneFiche['id'] == 'CL') {
					$valLink = anchor( 'comptable/validerFiche/'.$uneFiche['mois'].'/'.$uneFiche['idVisiteur'],  'Valider', 'title="Valider la fiche" onclick="return confirm(\'Voulez-vous vraiment valider cette fiche ?\');"');
					$refLink = anchor('comptable/refuserFiche/' . $uneFiche['mois'] . '/' . $uneFiche['idVisiteur'], 'Refuser', 'title="Refuser la fiche" onclick="return confirm(\'Voulez-vous vraiment refuser cette fiche ?\');"'
					);
				}

				echo
					'<tr>
					<td class="libelle">' . $uneFiche['idVisiteur'] . '</td>
					<td class="libelle">' . anchor('comptable/voirMaFiche/' . $uneFiche['mois'], $uneFiche['mois'], 'title="Consulter la fiche"') . '</td>
					<td class="libelle">' . $uneFiche['libelle'] . '</td>
					<td class="montant">' . $uneFiche['montantValide'] . '</td>
					<td class="date">' . $formattedDate . '</td>
					<td class="action">' . $valLink . '</td>
					<td class="action">' . $refLink . '</td>
				</tr>';
			}
			?>
		</tbody>
	</table>
</div>
<?= $this->endSection() ?>
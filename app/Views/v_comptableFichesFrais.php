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
                $dateModif = date_create($uneFiche['dateModif']);
                $formattedDate = $dateModif ? $dateModif->format('d/m/Y') : 'N/A';

                $valLink = '';
                $refLink = '';

                if ($uneFiche['id'] == 'CL') {
                    // Lien "Valider" inchangé
                    $valLink = anchor('comptable/validerFiche/'.$uneFiche['mois'].'/'.$uneFiche['idVisiteur'], 'Valider', 
                        'title="Valider la fiche" onclick="return confirm(\'Voulez-vous vraiment valider cette fiche ?\');"');

                    // Nouveau code pour le refus avec motif
                    $refLink = '<form action="'.site_url('comptable/refuserFiche/'.$uneFiche['mois'].'/'.$uneFiche['idVisiteur']).'" method="post" style="display:inline;">
                                    <input type="hidden" name="motif" id="motif_'.$uneFiche['mois'].'_'.$uneFiche['idVisiteur'].'">
                                    <a href="#" onclick="
                                        var motif = prompt(\'Entrez le motif de refus :\');
                                        if (motif) {
                                            document.getElementById(\'motif_'.$uneFiche['mois'].'_'.$uneFiche['idVisiteur'].'\').value = motif;
                                            this.parentElement.submit();
                                        }
                                        return false;
                                    ">Refuser</a>
                                </form>';
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
<?php
require_once RACINE . '/Core/Pompier.php';
require_once RACINE . '/Core/CollectionPompier.php';
require_once RACINE . '/Core/DAO/PompierDAO.php';
require_once RACINE . '/controleur/outils.php';

exigerPost('listePompiers');          // suppression : POST + jeton CSRF uniquement

$bip = trim($_POST['bip'] ?? '');
if ($bip !== '') {
    try {
        $dao = new PompierDAO();
        if ($dao->getByNumeroBip($bip) === null) {
            $_SESSION['message'] = "Pompier introuvable.";
        } else {
            $dao->supprimer($bip);
            $_SESSION['message'] = "Pompier (bip : $bip) supprimé.";
        }
    } catch (Exception $e) {
        $_SESSION['message'] = erreurTechnique($e, "Erreur lors de la suppression.");
    }
}

header('Location: index.php?action=listePompiers');
exit();

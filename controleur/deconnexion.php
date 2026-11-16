<?php
require_once RACINE . '/controleur/auth.php';

seDeconnecter();
header('Location: index.php?action=connexion');
exit();

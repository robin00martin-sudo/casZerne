# casZerne
Permet la gestion complète d'une caserne de pompiers volontaires.
  
  Permet la crétion de pompiers volontaires
  Permet la lecture des pompiers actif ou non
  Permet la modification des pompiers existant ainsi que leur activité
  Permet la suppresion de pompiers volontaire

Le script SQL permet de mettre en place la BDD, le fichier contient aussi un jeu de test.

! IMPORTANT !
  Une fois la BDD initialiser dans "modele/Connexion.php" veuillez renseigner vos info pour vous connecter à la BDD
  (login, mot de passe, nom de la table, IP serveur si vous en avez une sinon localhost)
! FIN IMPORTANT !

index.php -> Point d'entré.
vue -> permet d'avoir un affichage pour chaque interaction avec la BDD.
modele/Connexion.php -> permet la connexion à la BDD.
Core/ et Core/Dao -> sert principalement créer les objets en POO et à communiquer avec la BDD pour les données demandées.
controleur -> permet de relier le Core avec les bonnes vues.


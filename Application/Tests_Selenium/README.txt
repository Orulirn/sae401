Ce document sert à pouvoir réaliser de bon tests dans de bonnes conditions.

Pour ce faire, il faut prendre en compte plusieurs points :
- Faire attention à ce qu'on lance, certains tests (comme login ou register) n'ont pas besoin d'être connecté pour
    fonctionner, étant donné que c'est ce que l'on test. A l'inverse, la plupart des tests concernant de la gestion ont
    besoin d'une connection Administrateur, tandis que certains plus précis (comme la création d'équipe par un utilisateur),
    ont besoins d'une connexion en tant que joueur.

- Il faut également faire attention à avoir un jeu de données cohérent et complet, afin que les tests puissent
    s'effectuer sans problèmes ni manque d'informations.

- Il faut finalement regardé les informations rentrées dans les tests, par exemple pour ajouter une équipe à un tournoi,
    il recherche l'équipe par label, qui est lié au jeu de données utilisé. Il faut donc modifier certains champs pour
    quelques tests.
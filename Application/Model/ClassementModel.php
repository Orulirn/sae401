<?php
include_once "DatabaseConnection.php";

/**
 * @return array|false
 * @author Gallouin matisse
 * permet de récupérer tous les tournois dans la bdd trié par année
 */
function   getTournoiOrderAnnee()
{
    global $db;
    $req=$db->prepare("Select * from tournoi order by year desc");
    $req->execute();
    return $req->fetchAll();
}

/**
 * @param $idtournoi
 * @return array|false
 * @author Gallouin Matisse
 * fonction permettant de récupérer le nombre de victoire et de défaite de chaque équipe pour un tournoi donné en les triants par leur "score"
 */
function getClassementByTournoi($idtournoi)
{
    global $db ;
    $req=$db->prepare("SELECT teams.name,COUNT(r2.resultatRencontre) as victoire,COUNT(r.idTeamUn)+COUNT(r1.idTeamDeux) as defaite
FROM teams
    LEFT JOIN rencontre AS r ON r.idTeamUn = teams.idTeam and r.idTournoi=? and r.idTeamUn!=r.resultatRencontre
    LEFT JOIN rencontre AS r1 ON r1.idTeamDeux = teams.idTeam and r1.idTournoi=? and r1.idTeamDeux!=r1.resultatRencontre
    left join rencontre as r2 on r2.resultatRencontre=teams.idTeam and r2.idTournoi=?
    where teams.idtournoi=?
GROUP BY teams.idTeam
order by COUNT(r2.resultatRencontre)-(COUNT(r.idTeamUn)+COUNT(r1.idTeamDeux)) desc,victoire desc");
    $req->execute(array($idtournoi,$idtournoi,$idtournoi,$idtournoi));
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

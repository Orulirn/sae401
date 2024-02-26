<?php
include_once "DatabaseConnection.php";


function getClassementByTournoi($idtournoi)
{
    global $db ;
    $req=$db->prepare("SELECT teams.name,COUNT(r.idTeamUn)+COUNT(r1.idTeamDeux) as defaite,COUNT(r2.resultatRencontre) as victoire
FROM teams
    LEFT JOIN rencontre AS r ON r.idTeamUn = teams.idTeam and r.idTournoi=? and r.idTeamUn!=r.resultatRencontre
    LEFT JOIN rencontre AS r1 ON r1.idTeamDeux = teams.idTeam and r1.idTournoi=? and r1.idTeamDeux!=r1.resultatRencontre
    left join rencontre as r2 on r2.resultatRencontre=teams.idTeam and r2.idTournoi=?
GROUP BY teams.idTeam;");
    $req->execute(array($idtournoi,$idtournoi,$idtournoi));
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

<?php
include_once "DatabaseConnection.php";


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

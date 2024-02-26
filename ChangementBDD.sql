/*
 modification permettant le referencement de l'id de la team gagnante simplifiant ainsi le requetage
 */
alter TABLE rencontre
    ADD CONSTRAINT FK_resultatRencontre FOREIGN KEY(resultatRencontre) REFERENCES teams(idTeam);

/*
fonction pour récupérer le classement
 */
SELECT teams.name,COUNT(r.idTeamUn)+COUNT(r1.idTeamDeux) as defaite,COUNT(r2.resultatRencontre) as victoire
FROM teams
    LEFT JOIN rencontre AS r ON r.idTeamUn = teams.idTeam and r.idTournoi=1 and r.idTeamUn!=r.resultatRencontre
    LEFT JOIN rencontre AS r1 ON r1.idTeamDeux = teams.idTeam and r1.idTournoi=1 and r1.idTeamDeux!=r1.resultatRencontre
    left join rencontre as r2 on r2.resultatRencontre=teams.idTeam and r2.idTournoi=1
GROUP BY teams.idTeam;
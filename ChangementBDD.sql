/*
 modification permettant le referencement de l'id de la team gagnante simplifiant ainsi le requetage
 */
alter TABLE rencontre
    ADD CONSTRAINT FK_resultatRencontre FOREIGN KEY(resultatRencontre) REFERENCES teams(idTeam);

/*
 sauvegarde fonction victoire défaite
 */
SELECT name, COUNT(r1.resultatRencontre) as victoire,COUNT(r2.idTeamUn)+COUNT(r3.idTeamDeux) as defaite
from teams
         join rencontre r1 on idTeam=r1.resultatRencontre
         JOIN rencontre r2 on idTeam=r2.idTeamUn
         JOIN rencontre r3 on idTeam=r3.idTeamDeux
where r1.idTournoi=1
GROUP by teams.idTeam;
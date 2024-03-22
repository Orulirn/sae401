/*
 modification permettant le referencement de l'id de la team gagnante simplifiant ainsi le requetage
 BDD Matisse
 */
alter TABLE rencontre
    ADD CONSTRAINT FK_resultatRencontre FOREIGN KEY(resultatRencontre) REFERENCES teams(idTeam);

/*
 modif BDD pour lié les équipes à un tournoi
 BDD Matisse
 */
ALTER TABLE teams
    ADD COLUMN idTournoi int NOT NULL REFERENCES tournoi(idTournoi);


/*
 Ajout d'une table token pour la réinitialisation des MDP
 BDD Matisse
 */
CREATE TABLE token(
                      token varchar(250) PRIMARY KEY,
                      idUser int ,
                      FOREIGN KEY(idUser) REFERENCES users(idUser),
                      date timestamp not null
)
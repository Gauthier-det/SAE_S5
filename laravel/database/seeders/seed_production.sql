-- ============================================
-- Script SQL de seed pour la base MySQL de production
-- Basé sur InitialDatabaseSeeder.php et les migrations
-- ============================================

-- Désactiver temporairement les contraintes de clé étrangère
SET FOREIGN_KEY_CHECKS = 0;

-- ============================================
-- NETTOYAGE DES TABLES EXISTANTES
-- Utilisation de DELETE au lieu de TRUNCATE pour éviter les erreurs de FK
-- ============================================
DELETE FROM `SAN_USERS_RACES`;
DELETE FROM `SAN_CATEGORIES_RACES`;
DELETE FROM `SAN_ROLES_USERS`;
DELETE FROM `SAN_TEAMS_RACES`;
DELETE FROM `SAN_USERS_TEAMS`;
DELETE FROM `SAN_RACES`;
DELETE FROM `SAN_RAIDS`;
DELETE FROM `SAN_TEAMS`;
DELETE FROM `SAN_CLUBS`;
DELETE FROM `SAN_USERS`;
DELETE FROM `SAN_ROLES`;
DELETE FROM `SAN_CATEGORIES`;
DELETE FROM `SAN_ADDRESSES`;

-- ============================================
-- SAN_ADDRESSES
-- ============================================
INSERT INTO `SAN_ADDRESSES` (`ADD_ID`, `ADD_POSTAL_CODE`, `ADD_CITY`, `ADD_STREET_NAME`, `ADD_STREET_NUMBER`) VALUES
(1, 77000, 'Melun', 'Rue de la Rochette', '24'),
(2, 25000, 'Besançon', 'Avenue Léo Lagrange', '2'),
(3, 91000, 'EVRY', 'Place des Terrasses de l''Agora', '14'),
(4, 14000, 'CAEN', 'rue des bleuets', '28'),
(5, 77000, 'Melun', 'rue des Pins', '12'),
(6, 14123, 'IFS', 'rue des plantes', '45'),
(7, 25140, 'Charquemont', 'chemin du Lac', '5'),
(8, 14400, 'BAYEUX', 'bis rue du Parc', '8'),
(9, 91000, 'Evry', 'allée des Sports', '3'),
(10, 77100, 'MEAUX', 'rue des Pins', '12'),
(11, 25200, 'Montbéliard', 'avenue de l''Europe', '5'),
(12, 91300, 'MASSY', 'route de Bayonne', '21'),
(13, 77000, 'Melun', 'chemin de la Forêt', '45'),
(14, 77500, 'Chelles', 'rue du Moulin', '102'),
(15, 77000, 'Melun', 'place de la Mairie', '3'),
(16, 25200, 'Athis-Mons', 'rue des Peupliers', '2'),
(17, 25200, 'Montbéliard', 'rue du Collège', '6'),
(18, 25200, 'Montbéliard', 'rue des Ecoles', '4'),
(19, 77000, 'Melun', 'rue des roses', '22'),
(20, 14123, 'Ifs', 'rue des acacias', '35'),
(21, 14000, 'Caen', 'rue des chênes', '47'),
(22, 14123, 'Corrmeilles Le Royal', 'rue des tilleuls', '27'),
(23, 14123, 'Ifs', 'Rue des platanes', '25'),
(24, 77130, 'MONTERAUT', 'boulevard de la République', '7'),
(25, 77000, 'Melun', 'PARC INTERCOMMUNAL DEBREUIL 77000 MELUN', NULL);

-- ============================================
-- SAN_CATEGORIES
-- ============================================
INSERT INTO `SAN_CATEGORIES` (`CAT_ID`, `CAT_LABEL`) VALUES
(1, 'Mineur'),
(2, 'Majeur non licencié'),
(3, 'Licensié');

-- ============================================
-- SAN_ROLES
-- ============================================
INSERT INTO `SAN_ROLES` (`ROL_ID`, `ROL_NAME`) VALUES
(1, 'Coureur'),
(2, 'Gestionnaire de site');

-- ============================================
-- SAN_USERS
-- Note: Le mot de passe hashé correspond à 'pwd123' avec bcrypt
-- Vous devrez peut-être regénérer ces hashs en production
-- ============================================
INSERT INTO `SAN_USERS` (`USE_ID`, `ADD_ID`, `CLU_ID`, `USE_MAIL`, `USE_PASSWORD`, `USE_NAME`, `USE_LAST_NAME`, `USE_GENDER`, `USE_BIRTHDATE`, `USE_PHONE_NUMBER`, `USE_LICENCE_NUMBER`, `USE_MEMBERSHIP_DATE`, `USE_VALIDITY`) VALUES
(20, 1, NULL, 'admin.site@orient.action.fr', '$2y$12$n7uHqSRv6EAnz/bF53xh3.mm4krGg8.evsNxDUc7FlyWbsZfOhVvC', 'Admin', 'Site', 'Autre', '1970-01-01', '0600000000', NULL, NULL, '1970-01-01'),
(1, 5, NULL, 'julien.martin@caen.fr', '$2y$12$n7uHqSRv6EAnz/bF53xh3.mm4krGg8.evsNxDUc7FlyWbsZfOhVvC', 'Julien', 'MARTIN', 'Homme', '1990-04-15', '0612345678', 77001, '2022-01-01', '2024-12-31'),
(2, 6, NULL, 'c.dumont@email.fr', '$2y$12$n7uHqSRv6EAnz/bF53xh3.mm4krGg8.evsNxDUc7FlyWbsZfOhVvC', 'Clara', 'DUMONT', 'Femme', '1985-09-22', '0698765432', 25004, '2023-01-01', '2025-12-31'),
(3, 7, NULL, 'antoine.petit@gmail.com', '$2y$12$n7uHqSRv6EAnz/bF53xh3.mm4krGg8.evsNxDUc7FlyWbsZfOhVvC', 'Antoine', 'PETIT', 'Homme', '2002-01-03', '0711223344', NULL, NULL, '2025-01-11'),
(4, 8, NULL, 'sandra.info@wanadoo.fr', '$2y$12$n7uHqSRv6EAnz/bF53xh3.mm4krGg8.evsNxDUc7FlyWbsZfOhVvC', 'Sandra', 'MARVELI', 'Femme', '1995-07-18', '0655443322', 64005, '2023-01-01', '2024-12-31'),
(5, 9, NULL, 'lucas.bernard@test.fr', '$2y$12$n7uHqSRv6EAnz/bF53xh3.mm4krGg8.evsNxDUc7FlyWbsZfOhVvC', 'Lucas', 'BERNARD', 'Homme', '1988-11-30', '0766778899', 91002, '2022-01-01', '2024-12-31'),
(6, 10, NULL, 'claire.dupont@test.fr', '$2y$12$n7uHqSRv6EAnz/bF53xh3.mm4krGg8.evsNxDUc7FlyWbsZfOhVvC', 'Claire', 'DUPONT', 'Femme', '1992-05-14', '0612457890', 12045, '2021-01-01', '2024-12-31'),
(7, 11, NULL, 't.lefebvre@orange.fr', '$2y$12$n7uHqSRv6EAnz/bF53xh3.mm4krGg8.evsNxDUc7FlyWbsZfOhVvC', 'Thomas', 'LEFEBVRE', 'Homme', '1985-11-23', '0954892133', 2298, '2022-01-01', '2024-12-31'),
(8, 12, NULL, 'sophie.moreau@test.fr', '$2y$12$n7uHqSRv6EAnz/bF53xh3.mm4krGg8.evsNxDUc7FlyWbsZfOhVvC', 'Gwendoline', 'LUGNIER', 'Femme', '2001-02-02', '0781024456', 6003, '2023-01-01', '2025-12-31'),
(9, 13, NULL, 'thomas.leroy@test.fr', '$2y$12$n7uHqSRv6EAnz/bF53xh3.mm4krGg8.evsNxDUc7FlyWbsZfOhVvC', 'Thomas', 'LEROY', 'Homme', '1995-08-30', '0633571288', NULL, NULL, NULL),
(10, 14, NULL, 'julie.garnier@outlook.com', '$2y$12$n7uHqSRv6EAnz/bF53xh3.mm4krGg8.evsNxDUc7FlyWbsZfOhVvC', 'Julie', 'GARNIER', 'Femme', '1988-12-07', '0765901122', NULL, NULL, NULL),
(11, 15, NULL, 'm.rousseau@sfr.fr', '$2y$12$n7uHqSRv6EAnz/bF53xh3.mm4krGg8.evsNxDUc7FlyWbsZfOhVvC', 'Marc', 'ROUSSEAU', 'Homme', '1974-01-19', '0609883451', 67005, '2020-01-01', '2024-12-31'),
(12, 16, NULL, 'hugo.fontaine@test.fr', '$2y$12$n7uHqSRv6EAnz/bF53xh3.mm4krGg8.evsNxDUc7FlyWbsZfOhVvC', 'Hugo', 'FONTAINE', 'Homme', '2003-10-05', '0673849516', 91006, '2023-01-01', '2025-12-31'),
(13, 17, NULL, 'lea.caron@test.fr', '$2y$12$n7uHqSRv6EAnz/bF53xh3.mm4krGg8.evsNxDUc7FlyWbsZfOhVvC', 'Léa', 'CARON', 'Femme', '1990-04-27', '0614253647', NULL, NULL, NULL),
(14, 18, NULL, 'emma.petit@test.fr', '$2y$12$n7uHqSRv6EAnz/bF53xh3.mm4krGg8.evsNxDUc7FlyWbsZfOhVvC', 'Emma', 'PETIT', 'Femme', '2005-12-08', '0621436587', 77009, '2024-01-01', '2025-12-31'),
(15, 19, NULL, 'paul.dorbec@unicaen.fr', '$2y$12$n7uHqSRv6EAnz/bF53xh3.mm4krGg8.evsNxDUc7FlyWbsZfOhVvC', 'Paul', 'DORBEC', 'Homme', '1980-04-02', '0743672311', 23456, '2020-01-01', '2025-12-31'),
(16, 20, NULL, 'yohann.jacquier@unicaen.fr', '$2y$12$n7uHqSRv6EAnz/bF53xh3.mm4krGg8.evsNxDUc7FlyWbsZfOhVvC', 'Yohann', 'JACQUIER', 'Homme', '2016-06-03', '0642864628', NULL, NULL, NULL),
(17, 21, NULL, 'sylvian.delhoumi@unicaen.fr', '$2y$12$n7uHqSRv6EAnz/bF53xh3.mm4krGg8.evsNxDUc7FlyWbsZfOhVvC', 'Sylvian', 'DELHOUMI', 'Homme', '1985-06-02', '0705324567', NULL, NULL, '2025-02-02'),
(18, 22, NULL, 'jeanfrancois.anne@unicaen.fr', '$2y$12$n7uHqSRv6EAnz/bF53xh3.mm4krGg8.evsNxDUc7FlyWbsZfOhVvC', 'Jean-François', 'ANNE', 'Homme', '1964-11-05', '0645389485', 56723, '2020-01-01', '2025-12-31');

-- ============================================
-- SAN_CLUBS
-- ============================================
INSERT INTO `SAN_CLUBS` (`CLU_ID`, `USE_ID`, `ADD_ID`, `CLU_NAME`, `CLU_PHONE_NUMBER`) VALUES
(1, 6, 1, 'CO Azimut 77', '0613245698'),
(2, 3, 2, 'Balise 25', '0783295427'),
(3, 5, 3, 'Raidlinks', '0642376582'),
(4, 8, 4, 'VIKAZIM', '0764923785');

-- ============================================
-- Mise à jour des appartenances aux clubs des utilisateurs
-- ============================================
UPDATE `SAN_USERS` SET `CLU_ID` = 1 WHERE `USE_ID` IN (1, 6, 9, 10, 11, 15);
UPDATE `SAN_USERS` SET `CLU_ID` = 2 WHERE `USE_ID` IN (3, 7, 12, 13, 14);
UPDATE `SAN_USERS` SET `CLU_ID` = 3 WHERE `USE_ID` IN (5, 8);
UPDATE `SAN_USERS` SET `CLU_ID` = 4 WHERE `USE_ID` IN (4, 16, 17, 18);

-- ============================================
-- SAN_ROLES_USERS
-- ============================================
INSERT INTO `SAN_ROLES_USERS` (`ROL_ID`, `USE_ID`) VALUES
(2, 20);

-- ============================================
-- SAN_RAIDS
-- ============================================
INSERT INTO `SAN_RAIDS` (`RAI_ID`, `CLU_ID`, `ADD_ID`, `USE_ID`, `RAI_NB_RACES`, `RAI_NAME`, `RAI_MAIL`, `RAI_PHONE_NUMBER`, `RAI_WEB_SITE`, `RAI_IMAGE`, `RAI_TIME_START`, `RAI_TIME_END`, `RAI_REGISTRATION_START`, `RAI_REGISTRATION_END`) VALUES
(1, 1, 25, 15, 2, 'RAID CHAMPETRE', 'example@raidchampetre.fr', '0613245698', 'https://raidchampetre.fr', 'https://i.etsystatic.com/42843947/r/il/e47ebf/5040991793/il_570xN.5040991793_oj3z.jpg', '2025-11-13 08:00:00', '2025-11-14 18:00:00', '2025-08-10 00:00:00', '2025-10-30 00:00:00'),
(2, 1, 24, 6, 3, 'RAID O''Bivwak', 'example@raidobivwak.fr', '0613245699', 'https://raidobivwak.fr', 'https://i.etsystatic.com/21635101/r/il/c9f7ce/2718908178/il_570xN.2718908178_k5iq.jpg', '2026-05-23 10:00:00', '2026-05-24 18:00:00', '2026-01-18 00:00:00', '2026-04-30 00:00:00');

-- ============================================
-- SAN_RACES
-- ============================================
INSERT INTO `SAN_RACES` (`RAC_ID`, `USE_ID`, `RAI_ID`, `RAC_NAME`, `RAC_TIME_START`, `RAC_TIME_END`, `RAC_GENDER`, `RAC_TYPE`, `RAC_DIFFICULTY`, `RAC_MIN_PARTICIPANTS`, `RAC_MAX_PARTICIPANTS`, `RAC_MIN_TEAMS`, `RAC_MAX_TEAMS`, `RAC_MIN_TEAM_MEMBERS`, `RAC_MAX_TEAM_MEMBERS`, `RAC_AGE_MIN`, `RAC_AGE_MIDDLE`, `RAC_AGE_MAX`, `RAC_CHIP_MANDATORY`, `RAC_MEAL_PRICE`) VALUES
(1, 1, 1, 'Course LUTIN', '2025-11-13 10:00:00', '2025-11-13 18:00:00', 'Mixte', 'Loisir', 'Licorne', 2, 8, 1, 4, 2, 3, 12, 18, 99, 0, NULL),
(2, 15, 1, 'Course ELFE', '2025-11-14 05:00:00', '2025-11-14 18:00:00', 'Mixte', 'Compétition', 'Gazelle', 2, 8, 1, 4, 2, 3, 18, 25, 99, 0, NULL),
(3, 11, 2, 'Parcours A', '2026-05-23 10:00:00', '2026-05-23 20:00:00', 'Mixte', 'Compétition', 'Complexe', 10, 40, 2, 20, 2, 2, 21, 28, 99, 1, 5.00),
(4, 2, 2, 'Parcours B', '2026-05-24 10:00:00', '2026-05-24 18:00:00', 'Mixte', 'Loisirs', 'Modérée', 2, 8, 4, 4, 2, 2, 18, 25, 99, 0, 5.00);

-- ============================================
-- SAN_TEAMS
-- ============================================
INSERT INTO `SAN_TEAMS` (`TEA_ID`, `USE_ID`, `TEA_NAME`, `TEA_IMAGE`) VALUES
(1, 18, 'Equipe 1 LUTIN', NULL),
(2, 5, 'Equipe 2 LUTIN', NULL),
(3, 15, 'Equipe 3 LUTIN', NULL),
(4, 6, 'Equipe 1 ELFE', NULL),
(5, 17, 'Equipe 2 ELFE', NULL),
(6, 12, 'Equipe 3 ELFE', NULL),
(7, 14, 'Equipe 4 ELFE', NULL),
(8, 7, 'Equipe DORMEUR', NULL),
(9, 12, 'Equipe ATCHOUM', NULL),
(10, 12, 'Equipe SIMPLET', NULL);

-- ============================================
-- SAN_USERS_TEAMS
-- ============================================
INSERT INTO `SAN_USERS_TEAMS` (`USE_ID`, `TEA_ID`) VALUES
(4, 1),
(17, 1),
(5, 2),
(8, 2),
(15, 3),
(10, 3),
(6, 4),
(9, 4),
(4, 5),
(5, 5),
(12, 6),
(3, 6),
(14, 7),
(7, 7),
(7, 8),
(14, 8),
(18, 9),
(13, 9),
(10, 10),
(11, 10);

-- ============================================
-- SAN_TEAMS_RACES
-- ============================================
INSERT INTO `SAN_TEAMS_RACES` (`TEA_ID`, `RAC_ID`, `TER_TIME`, `TER_POINTS`, `TER_IS_VALID`, `TER_RACE_NUMBER`, `TER_RANK`, `TER_BONUS_POINTS`) VALUES
(1, 1, NULL, NULL, 1, 1, NULL, NULL),
(2, 1, NULL, NULL, 1, 2, NULL, NULL),
(3, 1, NULL, NULL, 1, 3, NULL, NULL),
(4, 2, NULL, NULL, 1, 1, NULL, NULL),
(5, 2, NULL, NULL, 1, 2, NULL, NULL),
(6, 2, NULL, NULL, 1, 3, NULL, NULL),
(7, 2, NULL, NULL, 1, 4, NULL, NULL),
(8, 4, NULL, NULL, NULL, 1, NULL, NULL),
(9, 4, NULL, NULL, NULL, 2, NULL, NULL),
(10, 4, NULL, NULL, NULL, 3, NULL, NULL);

-- ============================================
-- SAN_CATEGORIES_RACES
-- ============================================
INSERT INTO `SAN_CATEGORIES_RACES` (`RAC_ID`, `CAT_ID`, `CAR_PRICE`) VALUES
(1, 1, 0.00),
(1, 2, 0.00),
(1, 3, 0.00),
(2, 1, 0.00),
(2, 2, 0.00),
(2, 3, 0.00),
(3, 1, 7.00),
(3, 2, 12.00),
(3, 3, 5.00),
(4, 1, 7.00),
(4, 2, 12.00),
(4, 3, 5.00);

-- ============================================
-- SAN_USERS_RACES
-- ============================================
INSERT INTO `SAN_USERS_RACES` (`USE_ID`, `RAC_ID`, `USR_TIME`, `USR_CHIP_NUMBER`, `USR_PPS_FORM`) VALUES
-- Team 1 (TEA_ID 1) in Race 1
(18, 1, NULL, NULL, NULL),
(4, 1, NULL, NULL, NULL),
(17, 1, NULL, NULL, NULL),
-- Team 2 (TEA_ID 2) in Race 1
(5, 1, NULL, NULL, NULL),
(8, 1, NULL, NULL, NULL),
-- Team 3 (TEA_ID 3) in Race 1
(15, 1, NULL, NULL, NULL),
(10, 1, NULL, NULL, NULL),
-- Team 4 (TEA_ID 4) in Race 2
(6, 2, NULL, NULL, NULL),
(9, 2, NULL, NULL, NULL),
-- Team 5 (TEA_ID 5) in Race 2
(17, 2, NULL, NULL, NULL),
(4, 2, NULL, NULL, NULL),
(5, 2, NULL, NULL, NULL),
-- Team 6 (TEA_ID 6) in Race 2
(12, 2, NULL, NULL, NULL),
(3, 2, NULL, NULL, NULL),
-- Team 7 (TEA_ID 7) in Race 2
(14, 2, NULL, NULL, NULL),
(7, 2, NULL, NULL, NULL),
-- Team 8 (TEA_ID 8) in Race 4
(7, 4, NULL, NULL, NULL),
(14, 4, NULL, NULL, NULL),
-- Team 9 (TEA_ID 9) in Race 4
(12, 4, NULL, NULL, NULL),
(18, 4, NULL, NULL, NULL),
(13, 4, NULL, NULL, NULL),
-- Team 10 (TEA_ID 10) in Race 4
(10, 4, NULL, NULL, NULL),
(11, 4, NULL, NULL, NULL);

-- Réactiver les contraintes de clé étrangère
SET FOREIGN_KEY_CHECKS = 1;

-- ============================================
-- FIN DU SCRIPT DE SEED
-- ============================================

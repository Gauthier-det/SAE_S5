INSERT INTO SAN_ADDRESSES (ADD_ID, ADD_POSTAL_CODE, ADD_CITY, ADD_STREET_NAME, ADD_STREET_NUMBER) VALUES
(1, 50100, 'Cherbourg-en-Cotentin', 'Rue des Marins', '12'),
(2, 50100, 'Alençon', 'Rue Victor Hugo', '5'),
(3, 14000, 'Caen', 'Avenue des Sports', '7'),
(4, 76790, 'Étretat', 'Rue des Falaises', '3'),
(5, 75010, 'Paris', 'Rue de Paris', '21'),
(6, 75009, 'Paris', 'Rue Lafayette', '14'),
(7, 50110, 'Tourlaville', 'Rue des Mielles', '10'),
(8, 50760, 'Barfleur', 'Rue du Port', '3'),
(9, 76000, 'Rouen', 'Rue des Arts', '11'),
(10, 76600, 'Le Havre', 'Rue de la République', '6'),
(11, 14100, 'Lisieux', 'Rue des Lilas', '9'),
(12, 14400, 'Bayeux', 'Rue des Jardins', '3'),
(13, 14510, 'Houlgate', 'Rue du Casino', '4'),
(14, 50120, 'Équeurdreville', 'Rue des Poètes', '2'),
(15, 50200, 'Coutances', 'Rue des Tamaris', '5');

INSERT INTO SAN_CATEGORIES (CAT_ID, CAT_LABEL) VALUES
(1, 'Mineur'),
(2, 'Majeur non licencié'),
(3, 'Licensié');


INSERT INTO SAN_USERS (USE_ID, ADD_ID, CLU_ID, USE_MAIL, USE_PASSWORD,
                       USE_NAME, USE_LAST_NAME, USE_BIRTHDATE,
                       USE_PHONE_NUMBER, USE_LICENCE_NUMBER,
                       USE_PPS_FORM, USE_MEMBERSHIP_DATE)
VALUES
-- 1 : Admin
(1, 1, NULL, 'admin.site@example.com', 'pwd123', 'Admin', 'Site',
 '1980-01-01', 610000001, NULL, NULL, NULL),
-- 2 : Respo club 1 
(2, 2, null, 'marc.marquez@example.com', 'pwd123', 'Marc', 'Marquez',
 '1985-05-10', 610000002, 100002, NULL, '2021-01-01'),
-- 3 : Respo club 2 
(3, 3, null, 'fabio.quartararo@example.com', 'pwd123', 'Fabio', 'Quartararo',
 '1978-03-15', 610000003, 100003, NULL, '2021-01-01'),
-- 4 : Respo raid/races raid 1
(4, 2, null, 'loane.kante@example.com', 'pwd123', 'Loane', 'Kante',
 '2000-05-10', 610000004, 100006, NULL, '2023-01-01'),
-- 3 : Respo Raid 2 
(5, 3, null, 'jack.sparrow@example.com', 'pwd123', 'Jack', 'Sparrow',
 '1978-03-15', 610000005, 100007, NULL, '2021-01-01'),
 -- 4 : Respo race raid 2
(6, 3, null, 'grace.parker@example.com', 'pwd123', 'Grace', 'Parker',
 '1988-03-15', 610000006, 100008, NULL, '2021-01-01'),
-- Runners club 1 (x3) :
(7, 4, null, 'alice.durand@example.com', 'pwd123', 'Alice', 'Durand',
 '1990-06-01', 620000004, 200001, null, '2023-01-01'),
(8, 5, null, 'bob.douglas@example.com', 'pwd123', 'Bob', 'Douglas',
 '1992-02-01', 620000005, 200002, null, '2023-01-01'),
(9, 6, null, 'hugo.dialo@example.com', 'pwd123', 'Hugo', 'Dialo',
 '1995-09-15', 620000006, 200003, null, '2023-01-01'),
-- Runners club 2 (x2) :
(10, 7, null, 'ino.casablanca@example.com', 'pwd123', 'Ino', 'Casablanca',
 '1991-11-20', 620000007, 200004, null, '2023-01-01'),
(11, 8, null, 'cassiopee.guerdat@example.com', 'pwd123', 'Cassiopée', 'Guerdat',
 '1993-04-30', 620000008, 200005, null, '2023-01-01'),
-- Runner without club 
(12, 9, NULL, 'coureur.sansclub@example.com', 'pwd123', 'Chloe', 'Libre',
 '1998-01-10', 620000009, NULL, 'pps_chloe.pdf', '2024-01-01');

INSERT INTO SAN_CLUBS (CLU_ID, USE_ID, ADD_ID, CLU_NAME) VALUES
(1, 2, 1, 'CO-DE');
INSERT INTO SAN_CLUBS (CLU_ID, USE_ID, ADD_ID, CLU_NAME) VALUES
(2, 3, 3, 'L''Embuscade');

update SAN_USERS set clu_id = 1 where use_id in (2,4,7,8,9);
update SAN_USERS set clu_id = 2 where use_id in (3,5,6,10,11);

INSERT INTO SAN_ROLES (ROL_ID, ROL_NAME) VALUES
(1, 'Coureur'),
(2, 'Gestionnaire de site'),
(3, 'Responsable de club'),
(4, 'Responsable de raid'),
(5, 'Responsable de course');

INSERT INTO SAN_ROLES_USERS (USE_ID, ROL_ID) VALUES
(1, 2); -- admin
INSERT INTO SAN_ROLES_USERS (USE_ID, ROL_ID) VALUES
(2, 3),   
(3, 3);   -- Club responsible
INSERT INTO SAN_ROLES_USERS (USE_ID, ROL_ID) VALUES
(4, 4),   
(5, 4);   -- Raid Responsible
INSERT INTO SAN_ROLES_USERS (USE_ID, ROL_ID) VALUES
(4, 5),   
(6, 5);   -- Race responsibe
INSERT INTO SAN_ROLES_USERS (USE_ID, ROL_ID) VALUES
(2, 1), 
(3, 1), 
(5, 1), 
(6, 1), 
(7, 1),  
(8, 1),
(9, 1),
(10, 1),
(11, 1), 
(12, 1);   -- Runner

INSERT INTO SAN_RAIDS (RAI_ID, CLU_ID, ADD_ID, USE_ID, RAI_NAME, RAI_MAIL, RAI_PHONE_NUMBER, RAI_WEB_SITE, RAI_IMAGE, RAI_TIME_START, RAI_TIME_END, RAI_REGISTRATION_START, RAI_REGISTRATION_END) VALUES
-- Raid 1 organised by club 1
(1, 1, 7, 4, 'Raid Cotentin 2026', 'contact@raidcotentin.fr', null, 'https://raidcotentin.fr', 'raid_cotentin.jpg', '2025-10-10 08:00:00', '2025-10-10 20:00:00', '2025-09-01 00:00:00', '2026-09-30 23:59:59'),
-- Raid 2 organised by club 2
(2, 2, 4, 5, 'Raid de Vanves 2025', 'contact@trailvanves.fr', null, 'https://trailfalaises.fr', 'trail_falaises.jpg', '2026-04-20 07:30:00', '2026-04-20 19:00:00', '2025-12-01 00:00:00', '2026-04-15 23:59:59');

INSERT INTO SAN_RACES (RAC_ID, USE_ID, RAI_ID, RAC_TIME_START, RAC_TIME_END, RAC_TYPE, RAC_DIFFICULTY, RAC_MIN_PARTICIPANTS, RAC_MAX_PARTICIPANTS, RAC_MIN_TEAMS, RAC_MAX_TEAMS, RAC_TEAM_MEMBERS, RAC_AGE_MIN, RAC_AGE_MIDDLE, RAC_AGE_MAX) VALUES
-- Course 1 in Raid 1
(1, 4, 1, '2025-10-10 08:30:00', '2025-10-10 13:30:00', 'Compétitif', 'Moyen', 5, 200, 2, 50, 3, 12, 15, 18),
-- Course 2 in Raid 1
(2, 4, 1, '2025-10-10 12:30:00', '2025-10-10 18:30:00', 'Compétitif', 'Difficile', 4, 150, 2, 40, 2, 18, 25, 30),
-- Course 3 in Raid 2
(3, 6, 2, '2026-06-15 09:15:00', '2026-06-15 13:15:00', 'Compétitif', 'Moyen', 6, 120, 2, 30, 3, 10.00, 18, 20),
-- Course 4 in Raid 2
(4, 6, 3, '2026-04-20 08:00:00', '2026-04-20 11:30:00', 'Loisir', 'Facile', 4, 300, 2, 60, 2, 14, 17, 19);
-- Duration, results à supprimer, ages à remettre au bon type

INSERT INTO SAN_CATEGORIES_RACES (RAC_ID, CAT_ID, CAR_PRICE) VALUES
(1, 1, 8.00),
(1, 2, 12.00),
(1, 3, 7.00),
(2, 1, 4.00),
(2, 2, 7.00),
(2, 3, 4.00),
(3, 1, 10.00),
(3, 2, 15.00),
(3, 3, 7.50),
(4, 1, 6.00),
(4, 2, 8.00),
(4, 3, 6.00); -- Pricings

INSERT INTO SAN_TEAMS (TEA_ID, USE_ID, TEA_NAME, TEA_IMAGE) VALUES
(1, 2, 'Lunatic', NULL),
(2, 7, 'Arsenik', NULL),
(3, 10, 'Arctic Mokeys', NULL),
(4, 12, 'Pink Floyd', NULL);

INSERT INTO SAN_TEAMS_RACES (TEA_ID, RAC_ID, TER_TIME, TER_IS_VALID, TER_RACE_NUMBER) VALUES
(1, 1, '02:45:30', 1, 101), -- Team 1 Club 1 Race 1, 3 pers.
(3, 1, '01:55:00', 1, 402), -- Team 3 Club 2 Race 1, 3 pers.
(2, 2, '02:50:10', 1, 102), -- Team 2 Club 1 Race 2, 2 pers.
(4, 2, '02:45:12', 1, 501), -- Team 4 Club 4 Race 2, 2 pers.
(1, 3, null, 1, 103), -- Team 1 Club 1 Race 3, 3 pers.
(3, 3, null, 1, 502), -- Team 3 Club 2 Race 3, 3 pers.
(2, 4, null, 1, 201), -- Team 2 Club 1 Race 4, 2 pers.
(4, 4, null, 1, 601); -- Team 4 Club 2 Race 4, 2 pers.

INSERT INTO SAN_USERS_TEAMS (USE_ID, TEA_ID) VALUES
(7, 1),
(8, 1),
(9, 1), -- 3 pers. team 1
(10, 2),
(11, 2), -- 2 pers. team 2
(7, 3),
(8, 3),
(9, 3), -- 3 pers. team 3
(10, 4),
(3, 4); -- 2 pers. team 4

INSERT INTO SAN_USERS_RACES (USE_ID, RAC_ID, USR_CHIP_NUMBER, USR_TIME) VALUES
(7, 1, 1001, 165.50),
(8, 1, 1002, 170.20),
(9, 1, 1001, 165.50),
(10, 1, 1002, 170.20),
(11, 1, 1001, 165.50),
(12, 1, 1002, 170.20),
(7, 2, 1003, 295.56),
(8, 2, 1004, 310.30),
(10, 2, 1003, 295.56),
(3, 2, 1004, 310.30),
(7, 3, 1005, 185.29),
(8, 3, 1006, 190.10),
(9, 3, 1005, 185.29),
(10, 3, 1006, 190.10),
(11, 3, 1005, 185.29),
(12, 3, 1006, 190.10),
(7, 4, 1007, 120.50),
(8, 4, 1008, 118.40),
(10, 4, 1007, 120.50),
(3, 4, 1008, 118.40);


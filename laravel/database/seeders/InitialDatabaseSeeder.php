<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InitialDatabaseSeeder extends Seeder
{
    /**
     * Seeder complet pour le script de démonstration SAE S5
     * 
     * PARTIE WEB:
     * - Invité Secouard Stéphane: s'inscrit (pas pré-seedé)
     * - Responsable CO AZIMUT 77: modifie RAID OBIWAK
     * - DORBEC Paul: gestionnaire RAID, ajoute Parcours C
     * - MARTIN Julien: responsable courses, enregistre résultats LUTIN
     * 
     * PARTIE MOBILE:
     * - Sylvian DELHOUMI: crée équipe PROF dans Parcours C
     * - M. Anne bloqué (chevauchement), Mme Secouard OK, Jacquier bloqué (âge)
     * - MARTIN Julien offline: vérifie dossiers Parcours B, supprime SIMPLET
     */
    public function run(): void
    {
        // ========================================
        // ADDRESSES
        // ========================================
        DB::table('SAN_ADDRESSES')->insert([
            // Clubs
            ['ADD_ID' => 1, 'ADD_POSTAL_CODE' => 77000, 'ADD_CITY' => 'Melun', 'ADD_STREET_NAME' => 'Rue de la Rochette', 'ADD_STREET_NUMBER' => '24'],           // CO Azimut 77
            ['ADD_ID' => 2, 'ADD_POSTAL_CODE' => 25000, 'ADD_CITY' => 'Besançon', 'ADD_STREET_NAME' => 'Avenue Léo Lagrange', 'ADD_STREET_NUMBER' => '2'],         // Balise 25
            ['ADD_ID' => 3, 'ADD_POSTAL_CODE' => 91000, 'ADD_CITY' => 'EVRY', 'ADD_STREET_NAME' => "Place des Terrasses de l'Agora", 'ADD_STREET_NUMBER' => '14'], // Raidlinks
            ['ADD_ID' => 4, 'ADD_POSTAL_CODE' => 14000, 'ADD_CITY' => 'CAEN', 'ADD_STREET_NAME' => 'rue des bleuets', 'ADD_STREET_NUMBER' => '28'],                // VIKAZIM

            // Raids
            ['ADD_ID' => 24, 'ADD_POSTAL_CODE' => 77130, 'ADD_CITY' => 'MONTERAUT', 'ADD_STREET_NAME' => 'boulevard de la République', 'ADD_STREET_NUMBER' => '7'],
            ['ADD_ID' => 25, 'ADD_POSTAL_CODE' => 77000, 'ADD_CITY' => 'Melun', 'ADD_STREET_NAME' => 'PARC INTERCOMMUNAL DEBREUIL', 'ADD_STREET_NUMBER' => null],

            // Users (5-23)
            ['ADD_ID' => 5, 'ADD_POSTAL_CODE' => 77000, 'ADD_CITY' => 'Melun', 'ADD_STREET_NAME' => 'rue des Pins', 'ADD_STREET_NUMBER' => '12'],
            ['ADD_ID' => 6, 'ADD_POSTAL_CODE' => 14123, 'ADD_CITY' => 'IFS', 'ADD_STREET_NAME' => 'rue des plantes', 'ADD_STREET_NUMBER' => '45'],
            ['ADD_ID' => 7, 'ADD_POSTAL_CODE' => 25140, 'ADD_CITY' => 'Charquemont', 'ADD_STREET_NAME' => 'chemin du Lac', 'ADD_STREET_NUMBER' => '5'],
            ['ADD_ID' => 8, 'ADD_POSTAL_CODE' => 14400, 'ADD_CITY' => 'BAYEUX', 'ADD_STREET_NAME' => 'bis rue du Parc', 'ADD_STREET_NUMBER' => '8'],
            ['ADD_ID' => 9, 'ADD_POSTAL_CODE' => 91000, 'ADD_CITY' => 'Evry', 'ADD_STREET_NAME' => 'allée des Sports', 'ADD_STREET_NUMBER' => '3'],
            ['ADD_ID' => 10, 'ADD_POSTAL_CODE' => 77100, 'ADD_CITY' => 'MEAUX', 'ADD_STREET_NAME' => 'rue des Pins', 'ADD_STREET_NUMBER' => '12'],
            ['ADD_ID' => 11, 'ADD_POSTAL_CODE' => 25200, 'ADD_CITY' => 'Montbéliard', 'ADD_STREET_NAME' => "avenue de l'Europe", 'ADD_STREET_NUMBER' => '5'],
            ['ADD_ID' => 12, 'ADD_POSTAL_CODE' => 91300, 'ADD_CITY' => 'MASSY', 'ADD_STREET_NAME' => 'route de Bayonne', 'ADD_STREET_NUMBER' => '21'],
            ['ADD_ID' => 13, 'ADD_POSTAL_CODE' => 77000, 'ADD_CITY' => 'Melun', 'ADD_STREET_NAME' => 'chemin de la Forêt', 'ADD_STREET_NUMBER' => '45'],
            ['ADD_ID' => 14, 'ADD_POSTAL_CODE' => 77500, 'ADD_CITY' => 'Chelles', 'ADD_STREET_NAME' => 'rue du Moulin', 'ADD_STREET_NUMBER' => '102'],
            ['ADD_ID' => 15, 'ADD_POSTAL_CODE' => 77000, 'ADD_CITY' => 'Melun', 'ADD_STREET_NAME' => 'place de la Mairie', 'ADD_STREET_NUMBER' => '3'],
            ['ADD_ID' => 16, 'ADD_POSTAL_CODE' => 25200, 'ADD_CITY' => 'Athis-Mons', 'ADD_STREET_NAME' => 'rue des Peupliers', 'ADD_STREET_NUMBER' => '2'],
            ['ADD_ID' => 17, 'ADD_POSTAL_CODE' => 25200, 'ADD_CITY' => 'Montbéliard', 'ADD_STREET_NAME' => 'rue du Collège', 'ADD_STREET_NUMBER' => '6'],
            ['ADD_ID' => 18, 'ADD_POSTAL_CODE' => 25200, 'ADD_CITY' => 'Montbéliard', 'ADD_STREET_NAME' => "rue des Ecoles", 'ADD_STREET_NUMBER' => '4'],
            ['ADD_ID' => 19, 'ADD_POSTAL_CODE' => 77000, 'ADD_CITY' => 'Melun', 'ADD_STREET_NAME' => 'rue des roses', 'ADD_STREET_NUMBER' => '22'],
            ['ADD_ID' => 20, 'ADD_POSTAL_CODE' => 14123, 'ADD_CITY' => 'Ifs', 'ADD_STREET_NAME' => 'rue des acacias', 'ADD_STREET_NUMBER' => '35'],
            ['ADD_ID' => 21, 'ADD_POSTAL_CODE' => 14000, 'ADD_CITY' => 'Caen', 'ADD_STREET_NAME' => 'rue des chênes', 'ADD_STREET_NUMBER' => '47'],
            ['ADD_ID' => 22, 'ADD_POSTAL_CODE' => 14123, 'ADD_CITY' => 'Cormelles Le Royal', 'ADD_STREET_NAME' => 'rue des tilleuls', 'ADD_STREET_NUMBER' => '27'],
            ['ADD_ID' => 23, 'ADD_POSTAL_CODE' => 14123, 'ADD_CITY' => 'Ifs', 'ADD_STREET_NAME' => 'Rue des platanes', 'ADD_STREET_NUMBER' => '25'],
            ['ADD_ID' => 26, 'ADD_POSTAL_CODE' => 14000, 'ADD_CITY' => 'Caen', 'ADD_STREET_NAME' => 'rue des lilas', 'ADD_STREET_NUMBER' => '18'],
        ]);

        // ========================================
        // CATEGORIES
        // ========================================
        DB::table('SAN_CATEGORIES')->insert([
            ['CAT_ID' => 1, 'CAT_LABEL' => 'Mineur'],
            ['CAT_ID' => 2, 'CAT_LABEL' => 'Majeur non licencié'],
            ['CAT_ID' => 3, 'CAT_LABEL' => 'Licencié'],
        ]);

        // ========================================
        // ROLES
        // ========================================
        DB::table('SAN_ROLES')->insert([
            ['ROL_ID' => 1, 'ROL_NAME' => 'Coureur'],
            ['ROL_ID' => 2, 'ROL_NAME' => 'Gestionnaire de site']
        ]);

        $hashedPassword = Hash::make('pwd123');

        // ========================================
        // USERS
        // ========================================
        DB::table('SAN_USERS')->insert([
            // Admin
            ['USE_ID' => 0, 'ADD_ID' => 1, 'CLU_ID' => null, 'USE_MAIL' => 'admin.site@orient.action.fr', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Admin', 'USE_LAST_NAME' => 'Site', 'USE_GENDER' => 'Autre', 'USE_BIRTHDATE' => '1970-01-01', 'USE_PHONE_NUMBER' => '0600000000', 'USE_LICENCE_NUMBER' => null, 'USE_MEMBERSHIP_DATE' => '2022-01-01', 'USE_VALIDITY' => '1970-01-01'],

            // ---- CLUB CO AZIMUT 77 (CLU_ID=1) ----
            // USE_ID=1: MARTIN Julien - Responsable course LUTIN, avec licence
            ['USE_ID' => 1, 'ADD_ID' => 5, 'CLU_ID' => null, 'USE_MAIL' => 'julien.martin@caen.fr', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Julien', 'USE_LAST_NAME' => 'MARTIN', 'USE_GENDER' => 'Homme', 'USE_BIRTHDATE' => '1990-04-15', 'USE_PHONE_NUMBER' => '0612345678', 'USE_LICENCE_NUMBER' => 77001, 'USE_MEMBERSHIP_DATE' => '2022-01-01', 'USE_VALIDITY' => '2026-12-31'],

            // USE_ID=6: DUPONT Claire - Manager initial RAID OBIWAK (sera changée)
            ['USE_ID' => 6, 'ADD_ID' => 10, 'CLU_ID' => null, 'USE_MAIL' => 'claire.dupont@test.fr', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Claire', 'USE_LAST_NAME' => 'DUPONT', 'USE_GENDER' => 'Femme', 'USE_BIRTHDATE' => '1992-05-14', 'USE_PHONE_NUMBER' => '0612457890', 'USE_LICENCE_NUMBER' => 12045, 'USE_MEMBERSHIP_DATE' => '2021-01-01', 'USE_VALIDITY' => '2026-12-31'],

            // USE_ID=15: DORBEC Paul - Nouveau manager RAID OBIWAK, avec licence
            ['USE_ID' => 15, 'ADD_ID' => 19, 'CLU_ID' => null, 'USE_MAIL' => 'paul.dorbec@unicaen.fr', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Paul', 'USE_LAST_NAME' => 'DORBEC', 'USE_GENDER' => 'Homme', 'USE_BIRTHDATE' => '1980-04-02', 'USE_PHONE_NUMBER' => '0743672311', 'USE_LICENCE_NUMBER' => 23456, 'USE_MEMBERSHIP_DATE' => '2020-01-01', 'USE_VALIDITY' => '2026-12-31'],

            // USE_ID=10: GARNIER Julie - SANS LICENCE (ne peut pas être gestionnaire course)
            ['USE_ID' => 10, 'ADD_ID' => 14, 'CLU_ID' => null, 'USE_MAIL' => 'julie.garnier@outlook.com', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Julie', 'USE_LAST_NAME' => 'GARNIER', 'USE_GENDER' => 'Femme', 'USE_BIRTHDATE' => '1988-12-07', 'USE_PHONE_NUMBER' => '0765901122', 'USE_LICENCE_NUMBER' => null, 'USE_MEMBERSHIP_DATE' => '2022-01-01', 'USE_VALIDITY' => '2022-01-01'],

            // USE_ID=11: ROUSSEAU Marc - Responsable Parcours A
            ['USE_ID' => 11, 'ADD_ID' => 15, 'CLU_ID' => null, 'USE_MAIL' => 'm.rousseau@sfr.fr', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Marc', 'USE_LAST_NAME' => 'ROUSSEAU', 'USE_GENDER' => 'Homme', 'USE_BIRTHDATE' => '1974-01-19', 'USE_PHONE_NUMBER' => '0609883451', 'USE_LICENCE_NUMBER' => 67005, 'USE_MEMBERSHIP_DATE' => '2020-01-01', 'USE_VALIDITY' => '2026-12-31'],

            // USE_ID=9: LEROY Thomas
            ['USE_ID' => 9, 'ADD_ID' => 13, 'CLU_ID' => null, 'USE_MAIL' => 'thomas.leroy@test.fr', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Thomas', 'USE_LAST_NAME' => 'LEROY', 'USE_GENDER' => 'Homme', 'USE_BIRTHDATE' => '1995-08-30', 'USE_PHONE_NUMBER' => '0633571288', 'USE_LICENCE_NUMBER' => null, 'USE_MEMBERSHIP_DATE' => '2022-01-01', 'USE_VALIDITY' => '2022-01-01'],

            // ---- CLUB BALISE 25 (CLU_ID=2) ----
            // USE_ID=3: PETIT Antoine
            ['USE_ID' => 3, 'ADD_ID' => 7, 'CLU_ID' => null, 'USE_MAIL' => 'antoine.petit@gmail.com', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Antoine', 'USE_LAST_NAME' => 'PETIT', 'USE_GENDER' => 'Homme', 'USE_BIRTHDATE' => '2002-01-03', 'USE_PHONE_NUMBER' => '0711223344', 'USE_LICENCE_NUMBER' => null, 'USE_MEMBERSHIP_DATE' => '2022-01-01', 'USE_VALIDITY' => '2026-01-11'],

            // USE_ID=7: LEFEBVRE Thomas - Équipe DORMEUR
            ['USE_ID' => 7, 'ADD_ID' => 11, 'CLU_ID' => null, 'USE_MAIL' => 't.lefebvre@orange.fr', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Thomas', 'USE_LAST_NAME' => 'LEFEBVRE', 'USE_GENDER' => 'Homme', 'USE_BIRTHDATE' => '1985-11-23', 'USE_PHONE_NUMBER' => '0954892133', 'USE_LICENCE_NUMBER' => 2298, 'USE_MEMBERSHIP_DATE' => '2022-01-01', 'USE_VALIDITY' => '2026-12-31'],

            // USE_ID=12: FONTAINE Hugo
            ['USE_ID' => 12, 'ADD_ID' => 16, 'CLU_ID' => null, 'USE_MAIL' => 'hugo.fontaine@test.fr', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Hugo', 'USE_LAST_NAME' => 'FONTAINE', 'USE_GENDER' => 'Homme', 'USE_BIRTHDATE' => '2003-10-05', 'USE_PHONE_NUMBER' => '0673849516', 'USE_LICENCE_NUMBER' => 91006, 'USE_MEMBERSHIP_DATE' => '2023-01-01', 'USE_VALIDITY' => '2026-12-31'],

            // USE_ID=13: CARON Léa - Équipe ATCHOUM, doit compléter PPS
            ['USE_ID' => 13, 'ADD_ID' => 17, 'CLU_ID' => null, 'USE_MAIL' => 'lea.caron@test.fr', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Léa', 'USE_LAST_NAME' => 'CARON', 'USE_GENDER' => 'Femme', 'USE_BIRTHDATE' => '1990-04-27', 'USE_PHONE_NUMBER' => '0614253647', 'USE_LICENCE_NUMBER' => null, 'USE_MEMBERSHIP_DATE' => '2022-01-01', 'USE_VALIDITY' => '2022-01-01'],

            // USE_ID=14: PETIT Emma - Équipe DORMEUR
            ['USE_ID' => 14, 'ADD_ID' => 18, 'CLU_ID' => null, 'USE_MAIL' => 'emma.petit@test.fr', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Emma', 'USE_LAST_NAME' => 'PETIT', 'USE_GENDER' => 'Femme', 'USE_BIRTHDATE' => '2005-12-08', 'USE_PHONE_NUMBER' => '0621436587', 'USE_LICENCE_NUMBER' => 77009, 'USE_MEMBERSHIP_DATE' => '2024-01-01', 'USE_VALIDITY' => '2026-12-31'],

            // ---- CLUB RAIDLINKS (CLU_ID=3) ----
            // USE_ID=5: BERNARD Lucas
            ['USE_ID' => 5, 'ADD_ID' => 9, 'CLU_ID' => null, 'USE_MAIL' => 'lucas.bernard@test.fr', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Lucas', 'USE_LAST_NAME' => 'BERNARD', 'USE_GENDER' => 'Homme', 'USE_BIRTHDATE' => '1988-11-30', 'USE_PHONE_NUMBER' => '0766778899', 'USE_LICENCE_NUMBER' => 91002, 'USE_MEMBERSHIP_DATE' => '2022-01-01', 'USE_VALIDITY' => '2026-12-31'],

            // USE_ID=8: LUGNIER Gwendoline - Manager Club VIKAZIM (déjà manager → ne peut pas gérer nouveau club)
            ['USE_ID' => 8, 'ADD_ID' => 12, 'CLU_ID' => null, 'USE_MAIL' => 'gwendoline.lugnier@test.fr', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Gwendoline', 'USE_LAST_NAME' => 'LUGNIER', 'USE_GENDER' => 'Femme', 'USE_BIRTHDATE' => '2001-02-02', 'USE_PHONE_NUMBER' => '0781024456', 'USE_LICENCE_NUMBER' => 6003, 'USE_MEMBERSHIP_DATE' => '2023-01-01', 'USE_VALIDITY' => '2026-12-31'],

            // USE_ID=2: DUMONT Clara - Responsable Parcours B, candidate manager nouveau club IFSGO
            ['USE_ID' => 2, 'ADD_ID' => 6, 'CLU_ID' => null, 'USE_MAIL' => 'c.dumont@email.fr', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Clara', 'USE_LAST_NAME' => 'DUMONT', 'USE_GENDER' => 'Femme', 'USE_BIRTHDATE' => '1985-09-22', 'USE_PHONE_NUMBER' => '0698765432', 'USE_LICENCE_NUMBER' => 25004, 'USE_MEMBERSHIP_DATE' => '2023-01-01', 'USE_VALIDITY' => '2026-12-31'],

            // ---- CLUB VIKAZIM (CLU_ID=4) - PARTIE MOBILE ----
            // USE_ID=4: MARVELI Sandra
            ['USE_ID' => 4, 'ADD_ID' => 8, 'CLU_ID' => null, 'USE_MAIL' => 'sandra.info@wanadoo.fr', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Sandra', 'USE_LAST_NAME' => 'MARVELI', 'USE_GENDER' => 'Femme', 'USE_BIRTHDATE' => '1995-07-18', 'USE_PHONE_NUMBER' => '0655443322', 'USE_LICENCE_NUMBER' => 64005, 'USE_MEMBERSHIP_DATE' => '2023-01-01', 'USE_VALIDITY' => '2026-12-31'],

            // USE_ID=17: DELHOUMI Sylvian - Utilisateur mobile principal, avec licence
            ['USE_ID' => 17, 'ADD_ID' => 21, 'CLU_ID' => null, 'USE_MAIL' => 'sylvian.delhoumi@unicaen.fr', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Sylvian', 'USE_LAST_NAME' => 'DELHOUMI', 'USE_GENDER' => 'Homme', 'USE_BIRTHDATE' => '1985-06-02', 'USE_PHONE_NUMBER' => '0705324567', 'USE_LICENCE_NUMBER' => 14567, 'USE_MEMBERSHIP_DATE' => '2024-01-01', 'USE_VALIDITY' => '2026-12-31'],

            // USE_ID=18: ANNE Jean-François - Inscrit au Parcours B (chevauchement avec Parcours C)
            ['USE_ID' => 18, 'ADD_ID' => 22, 'CLU_ID' => null, 'USE_MAIL' => 'jeanfrancois.anne@unicaen.fr', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Jean-François', 'USE_LAST_NAME' => 'ANNE', 'USE_GENDER' => 'Homme', 'USE_BIRTHDATE' => '1964-11-05', 'USE_PHONE_NUMBER' => '0645389485', 'USE_LICENCE_NUMBER' => 56723, 'USE_MEMBERSHIP_DATE' => '2020-01-01', 'USE_VALIDITY' => '2026-12-31'],

            // USE_ID=19: SECOUARD Marie - Peut être ajoutée à l'équipe PROF
            ['USE_ID' => 19, 'ADD_ID' => 26, 'CLU_ID' => null, 'USE_MAIL' => 'marie.secouard@unicaen.fr', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Marie', 'USE_LAST_NAME' => 'SECOUARD', 'USE_GENDER' => 'Femme', 'USE_BIRTHDATE' => '1990-03-15', 'USE_PHONE_NUMBER' => '0612345679', 'USE_LICENCE_NUMBER' => 78901, 'USE_MEMBERSHIP_DATE' => '2024-01-01', 'USE_VALIDITY' => '2026-12-31'],

            // USE_ID=16: JACQUIER Yohann - Trop jeune (12 ans en mai 2026, Parcours C exige 14+)
            ['USE_ID' => 16, 'ADD_ID' => 20, 'CLU_ID' => null, 'USE_MAIL' => 'yohann.jacquier@unicaen.fr', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Yohann', 'USE_LAST_NAME' => 'JACQUIER', 'USE_GENDER' => 'Homme', 'USE_BIRTHDATE' => '2016-06-03', 'USE_PHONE_NUMBER' => '0642864628', 'USE_LICENCE_NUMBER' => null, 'USE_MEMBERSHIP_DATE' => '2024-01-01', 'USE_VALIDITY' => '2024-01-01'],
        ]);

        // ========================================
        // CLUBS
        // ========================================
        DB::table('SAN_CLUBS')->insert([
            // CO Azimut 77: Manager = DUPONT Claire (pour OBIWAK)
            ['CLU_ID' => 1, 'USE_ID' => 6, 'ADD_ID' => 1, 'CLU_NAME' => 'CO Azimut 77', 'CLU_PHONE_NUMBER' => '0613245698'],
            ['CLU_ID' => 2, 'USE_ID' => 3, 'ADD_ID' => 2, 'CLU_NAME' => 'Balise 25', 'CLU_PHONE_NUMBER' => '0783295427'],
            ['CLU_ID' => 3, 'USE_ID' => 5, 'ADD_ID' => 3, 'CLU_NAME' => 'Raidlinks', 'CLU_PHONE_NUMBER' => '0642376582'],
            // VIKAZIM: Manager = LUGNIER Gwendoline (déjà manager → bloque création nouveau club)
            ['CLU_ID' => 4, 'USE_ID' => 8, 'ADD_ID' => 4, 'CLU_NAME' => 'VIKAZIM', 'CLU_PHONE_NUMBER' => '0764923785'],
        ]);

        // ========================================
        // UPDATE USER CLUB MEMBERSHIPS
        // ========================================
        // CLU_ID=1: CO Azimut 77
        DB::table('SAN_USERS')->whereIn('USE_ID', [1, 6, 9, 10, 11, 15])->update(['CLU_ID' => 1]);
        // CLU_ID=2: Balise 25
        DB::table('SAN_USERS')->whereIn('USE_ID', [3, 7, 12, 13, 14])->update(['CLU_ID' => 2]);
        // CLU_ID=3: Raidlinks
        DB::table('SAN_USERS')->whereIn('USE_ID', [2, 5, 8])->update(['CLU_ID' => 3]);
        // CLU_ID=4: VIKAZIM (utilisateurs mobile)
        DB::table('SAN_USERS')->whereIn('USE_ID', [4, 16, 17, 18, 19])->update(['CLU_ID' => 4]);

        // ========================================
        // ROLES
        // ========================================
        DB::table('SAN_ROLES_USERS')->insert([
            ['ROL_ID' => 2, 'USE_ID' => 0]  // Admin
        ]);

        // ========================================
        // RAIDS
        // ========================================
        DB::table('SAN_RAIDS')->insert([
            // RAID CHAMPETRE - Pour course LUTIN (responsable: MARTIN Julien via DORBEC initialement)
            [
                'RAI_ID' => 1,
                'CLU_ID' => 1,
                'ADD_ID' => 25,
                'USE_ID' => 15,  // DORBEC Paul
                'RAI_NB_RACES' => 2,
                'RAI_NAME' => 'RAID CHAMPETRE',
                'RAI_MAIL' => null,
                'RAI_PHONE_NUMBER' => '0613245698',
                'RAI_WEB_SITE' => 'https://raidchampetre.fr',
                'RAI_IMAGE' => null,
                'RAI_TIME_START' => '2025-11-13 08:00:00',
                'RAI_TIME_END' => '2025-11-14 18:00:00',
                'RAI_REGISTRATION_START' => '2025-08-10 00:00:00',
                'RAI_REGISTRATION_END' => '2025-10-30 23:59:59'
            ],

            // RAID O'BIVWAK - CLU_ID=1 (CO Azimut 77), Manager initial = DUPONT Claire
            // La date de fin inscription sera modifiée de 30/04 à 06/05/2026
            // Le manager sera changé de DUPONT Claire à DORBEC Paul
            [
                'RAI_ID' => 2,
                'CLU_ID' => 1,  // CO Azimut 77 (pas VIKAZIM!)
                'ADD_ID' => 24,
                'USE_ID' => 6,  // DUPONT Claire (sera changée à DORBEC Paul)
                'RAI_NB_RACES' => 3,  // Parcours A, B, C (C à créer)
                'RAI_NAME' => "RAID O'Bivwak",
                'RAI_MAIL' => null,
                'RAI_PHONE_NUMBER' => '0613245699',
                'RAI_WEB_SITE' => 'https://raidobivwak.fr',
                'RAI_IMAGE' => null,
                'RAI_TIME_START' => '2026-05-23 10:00:00',
                'RAI_TIME_END' => '2026-05-24 18:00:00',
                'RAI_REGISTRATION_START' => '2026-01-19 00:00:00',
                'RAI_REGISTRATION_END' => '2026-04-30 00:00:00'  // À modifier vers 06/05/2026
            ],
        ]);

        // ========================================
        // RACES
        // ========================================
        DB::table('SAN_RACES')->insert([
            // Course LUTIN - Responsable MARTIN Julien (pour enregistrer résultats)
            [
                'RAC_ID' => 1,
                'USE_ID' => 1,  // MARTIN Julien
                'RAI_ID' => 1,
                'RAC_NAME' => 'Course LUTIN',
                'RAC_TIME_START' => '2025-11-13 10:00:00',
                'RAC_TIME_END' => '2025-11-13 18:00:00',
                'RAC_GENDER' => 'Mixte',
                'RAC_TYPE' => 'Loisir',
                'RAC_DIFFICULTY' => 'Licorne',
                'RAC_MIN_PARTICIPANTS' => 2,
                'RAC_MAX_PARTICIPANTS' => 8,
                'RAC_MIN_TEAMS' => 1,
                'RAC_MAX_TEAMS' => 4,
                'RAC_MIN_TEAM_MEMBERS' => 2,
                'RAC_MAX_TEAM_MEMBERS' => 3,
                'RAC_AGE_MIN' => 12,
                'RAC_AGE_MIDDLE' => 18,
                'RAC_AGE_MAX' => 99,
                'RAC_CHIP_MANDATORY' => 0
            ],

            // Course ELFE
            [
                'RAC_ID' => 2,
                'USE_ID' => 15,  // DORBEC Paul
                'RAI_ID' => 1,
                'RAC_NAME' => 'Course ELFE',
                'RAC_TIME_START' => '2025-11-14 05:00:00',
                'RAC_TIME_END' => '2025-11-14 18:00:00',
                'RAC_GENDER' => 'Mixte',
                'RAC_TYPE' => 'Compétition',
                'RAC_DIFFICULTY' => 'Gazelle',
                'RAC_MIN_PARTICIPANTS' => 2,
                'RAC_MAX_PARTICIPANTS' => 8,
                'RAC_MIN_TEAMS' => 1,
                'RAC_MAX_TEAMS' => 4,
                'RAC_MIN_TEAM_MEMBERS' => 2,
                'RAC_MAX_TEAM_MEMBERS' => 3,
                'RAC_AGE_MIN' => 18,
                'RAC_AGE_MIDDLE' => 25,
                'RAC_AGE_MAX' => 99,
                'RAC_CHIP_MANDATORY' => 0
            ],

            // Parcours A - OBIWAK
            [
                'RAC_ID' => 3,
                'USE_ID' => 11,  // ROUSSEAU Marc
                'RAI_ID' => 2,
                'RAC_NAME' => 'Parcours A',
                'RAC_TIME_START' => '2026-05-23 10:00:00',
                'RAC_TIME_END' => '2026-05-23 20:00:00',
                'RAC_GENDER' => 'Mixte',
                'RAC_TYPE' => 'Compétition',
                'RAC_DIFFICULTY' => 'Complexe',
                'RAC_MIN_PARTICIPANTS' => 10,
                'RAC_MAX_PARTICIPANTS' => 40,
                'RAC_MIN_TEAMS' => 2,
                'RAC_MAX_TEAMS' => 20,
                'RAC_MIN_TEAM_MEMBERS' => 2,
                'RAC_MAX_TEAM_MEMBERS' => 2,
                'RAC_AGE_MIN' => 21,
                'RAC_AGE_MIDDLE' => 28,
                'RAC_AGE_MAX' => 99,
                'RAC_CHIP_MANDATORY' => 1
            ],

            // Parcours B - OBIWAK - Pour scénario offline (SIMPLET, ATCHOUM, DORMEUR)
            // Dates: 24/05/2026 14:00-17:00 (chevauche avec Parcours C)
            [
                'RAC_ID' => 4,
                'USE_ID' => 2,  // DUMONT Clara (sera changé à MARTIN Julien)
                'RAI_ID' => 2,
                'RAC_NAME' => 'Parcours B',
                'RAC_TIME_START' => '2026-05-24 14:00:00',  // Même heure que Parcours C
                'RAC_TIME_END' => '2026-05-24 17:00:00',
                'RAC_GENDER' => 'Mixte',
                'RAC_TYPE' => 'Loisirs',
                'RAC_DIFFICULTY' => 'Modérée',
                'RAC_MIN_PARTICIPANTS' => 2,
                'RAC_MAX_PARTICIPANTS' => 12,
                'RAC_MIN_TEAMS' => 1,
                'RAC_MAX_TEAMS' => 4,
                'RAC_MIN_TEAM_MEMBERS' => 2,
                'RAC_MAX_TEAM_MEMBERS' => 2,
                'RAC_AGE_MIN' => 18,
                'RAC_AGE_MIDDLE' => 25,
                'RAC_AGE_MAX' => 99,
                'RAC_CHIP_MANDATORY' => 0
            ],

            // NOTE: Parcours C sera créé via l'app mobile par Delhoumi
            // Dates prévues: 24/05/2026 14:00-17:00, AGE_MIN=14
        ]);

        // ========================================
        // TEAMS - Pour Parcours B (scénario offline)
        // ========================================
        DB::table('SAN_TEAMS')->insert([
            // Équipes LUTIN
            ['TEA_ID' => 1, 'USE_ID' => 18, 'TEA_NAME' => 'Equipe 1 LUTIN', 'TEA_IMAGE' => null],
            ['TEA_ID' => 2, 'USE_ID' => 5, 'TEA_NAME' => 'Equipe 2 LUTIN', 'TEA_IMAGE' => null],
            ['TEA_ID' => 3, 'USE_ID' => 15, 'TEA_NAME' => 'Equipe 3 LUTIN', 'TEA_IMAGE' => null],

            // Équipes ELFE
            ['TEA_ID' => 4, 'USE_ID' => 6, 'TEA_NAME' => 'Equipe 1 ELFE', 'TEA_IMAGE' => null],
            ['TEA_ID' => 5, 'USE_ID' => 17, 'TEA_NAME' => 'Equipe 2 ELFE', 'TEA_IMAGE' => null],
            ['TEA_ID' => 6, 'USE_ID' => 12, 'TEA_NAME' => 'Equipe 3 ELFE', 'TEA_IMAGE' => null],
            ['TEA_ID' => 7, 'USE_ID' => 14, 'TEA_NAME' => 'Equipe 4 ELFE', 'TEA_IMAGE' => null],

            // Équipes Parcours B (scénario offline MARTIN Julien)
            ['TEA_ID' => 8, 'USE_ID' => 7, 'TEA_NAME' => 'Equipe DORMEUR', 'TEA_IMAGE' => null],  // LEFEBVRE Thomas
            ['TEA_ID' => 9, 'USE_ID' => 18, 'TEA_NAME' => 'Equipe ATCHOUM', 'TEA_IMAGE' => null], // ANNE J-F (manager)
            ['TEA_ID' => 10, 'USE_ID' => 10, 'TEA_NAME' => 'Equipe SIMPLET', 'TEA_IMAGE' => null], // GARNIER Julie (à supprimer)
        ]);

        // ========================================
        // TEAM MEMBERS
        // ========================================
        DB::table('SAN_USERS_TEAMS')->insert([
            // Équipe 1 LUTIN
            ['USE_ID' => 4, 'TEA_ID' => 1],
            ['USE_ID' => 17, 'TEA_ID' => 1],

            // Équipe 2 LUTIN
            ['USE_ID' => 5, 'TEA_ID' => 2],
            ['USE_ID' => 8, 'TEA_ID' => 2],

            // Équipe 3 LUTIN
            ['USE_ID' => 15, 'TEA_ID' => 3],
            ['USE_ID' => 10, 'TEA_ID' => 3],

            // Équipe 1 ELFE
            ['USE_ID' => 6, 'TEA_ID' => 4],
            ['USE_ID' => 9, 'TEA_ID' => 4],

            // Équipe 2 ELFE
            ['USE_ID' => 4, 'TEA_ID' => 5],
            ['USE_ID' => 5, 'TEA_ID' => 5],

            // Équipe 3 ELFE
            ['USE_ID' => 12, 'TEA_ID' => 6],
            ['USE_ID' => 3, 'TEA_ID' => 6],

            // Équipe 4 ELFE
            ['USE_ID' => 14, 'TEA_ID' => 7],
            ['USE_ID' => 7, 'TEA_ID' => 7],

            // Équipe DORMEUR (Parcours B)
            ['USE_ID' => 7, 'TEA_ID' => 8],   // LEFEBVRE Thomas
            ['USE_ID' => 14, 'TEA_ID' => 8],  // PETIT Emma

            // Équipe ATCHOUM (Parcours B) - Léa Caron doit compléter son PPS
            ['USE_ID' => 18, 'TEA_ID' => 9],  // ANNE Jean-François (manager)
            ['USE_ID' => 13, 'TEA_ID' => 9],  // CARON Léa (PPS à compléter: 2024-8YSKLL)

            // Équipe SIMPLET (Parcours B) - À supprimer, Julie sans PPS
            ['USE_ID' => 10, 'TEA_ID' => 10], // GARNIER Julie (pas de PPS → supprimer)
            ['USE_ID' => 11, 'TEA_ID' => 10], // ROUSSEAU Marc
        ]);

        // ========================================
        // TEAM RACE REGISTRATIONS
        // ========================================
        DB::table('SAN_TEAMS_RACES')->insert([
            // LUTIN
            ['TEA_ID' => 1, 'RAC_ID' => 1, 'TER_TIME' => null, 'TER_POINTS' => null, 'TER_IS_VALID' => null, 'TER_RACE_NUMBER' => 1],
            ['TEA_ID' => 2, 'RAC_ID' => 1, 'TER_TIME' => null, 'TER_POINTS' => null, 'TER_IS_VALID' => null, 'TER_RACE_NUMBER' => 2],
            ['TEA_ID' => 3, 'RAC_ID' => 1, 'TER_TIME' => null, 'TER_POINTS' => null, 'TER_IS_VALID' => null, 'TER_RACE_NUMBER' => 3],

            // ELFE
            ['TEA_ID' => 4, 'RAC_ID' => 2, 'TER_TIME' => null, 'TER_POINTS' => null, 'TER_IS_VALID' => null, 'TER_RACE_NUMBER' => 1],
            ['TEA_ID' => 5, 'RAC_ID' => 2, 'TER_TIME' => null, 'TER_POINTS' => null, 'TER_IS_VALID' => null, 'TER_RACE_NUMBER' => 2],
            ['TEA_ID' => 6, 'RAC_ID' => 2, 'TER_TIME' => null, 'TER_POINTS' => null, 'TER_IS_VALID' => null, 'TER_RACE_NUMBER' => 3],
            ['TEA_ID' => 7, 'RAC_ID' => 2, 'TER_TIME' => null, 'TER_POINTS' => null, 'TER_IS_VALID' => null, 'TER_RACE_NUMBER' => 4],

            // Parcours B - Équipes pour scénario offline
            ['TEA_ID' => 8, 'RAC_ID' => 4, 'TER_TIME' => null, 'TER_POINTS' => null, 'TER_IS_VALID' => null, 'TER_RACE_NUMBER' => 1],  // DORMEUR
            ['TEA_ID' => 9, 'RAC_ID' => 4, 'TER_TIME' => null, 'TER_POINTS' => null, 'TER_IS_VALID' => null, 'TER_RACE_NUMBER' => 2],  // ATCHOUM
            ['TEA_ID' => 10, 'RAC_ID' => 4, 'TER_TIME' => null, 'TER_POINTS' => null, 'TER_IS_VALID' => null, 'TER_RACE_NUMBER' => 3], // SIMPLET
        ]);

        // ========================================
        // CATEGORY PRICES
        // ========================================
        DB::table('SAN_CATEGORIES_RACES')->insert([
            // LUTIN
            ['RAC_ID' => 1, 'CAT_ID' => 1, 'CAR_PRICE' => 0.00],
            ['RAC_ID' => 1, 'CAT_ID' => 2, 'CAR_PRICE' => 0.00],
            ['RAC_ID' => 1, 'CAT_ID' => 3, 'CAR_PRICE' => 0.00],

            // ELFE
            ['RAC_ID' => 2, 'CAT_ID' => 1, 'CAR_PRICE' => 0.00],
            ['RAC_ID' => 2, 'CAT_ID' => 2, 'CAR_PRICE' => 0.00],
            ['RAC_ID' => 2, 'CAT_ID' => 3, 'CAR_PRICE' => 0.00],

            // Parcours A
            ['RAC_ID' => 3, 'CAT_ID' => 1, 'CAR_PRICE' => 7.00],
            ['RAC_ID' => 3, 'CAT_ID' => 2, 'CAR_PRICE' => 12.00],
            ['RAC_ID' => 3, 'CAT_ID' => 3, 'CAR_PRICE' => 5.00],

            // Parcours B
            ['RAC_ID' => 4, 'CAT_ID' => 1, 'CAR_PRICE' => 7.00],
            ['RAC_ID' => 4, 'CAT_ID' => 2, 'CAR_PRICE' => 12.00],
            ['RAC_ID' => 4, 'CAT_ID' => 3, 'CAR_PRICE' => 5.00],
        ]);

        // ========================================
        // USER RACE REGISTRATIONS
        // ANNE inscrit au Parcours B → bloque son inscription au Parcours C (chevauchement)
        // ========================================
        DB::table('SAN_USERS_RACES')->insert([
            // Membres équipe ATCHOUM sur Parcours B
            ['USE_ID' => 18, 'RAC_ID' => 4, 'USR_CHIP_NUMBER' => null, 'USR_TIME' => null, 'USR_PPS_FORM' => null],  // ANNE J-F
            ['USE_ID' => 13, 'RAC_ID' => 4, 'USR_CHIP_NUMBER' => null, 'USR_TIME' => null, 'USR_PPS_FORM' => null],  // CARON Léa (PPS à compléter)

            // Membres équipe DORMEUR sur Parcours B
            ['USE_ID' => 7, 'RAC_ID' => 4, 'USR_CHIP_NUMBER' => null, 'USR_TIME' => null, 'USR_PPS_FORM' => null],   // LEFEBVRE Thomas
            ['USE_ID' => 14, 'RAC_ID' => 4, 'USR_CHIP_NUMBER' => null, 'USR_TIME' => null, 'USR_PPS_FORM' => null],  // PETIT Emma

            // Membres équipe SIMPLET sur Parcours B
            ['USE_ID' => 10, 'RAC_ID' => 4, 'USR_CHIP_NUMBER' => null, 'USR_TIME' => null, 'USR_PPS_FORM' => null],  // GARNIER Julie (pas de PPS)
            ['USE_ID' => 11, 'RAC_ID' => 4, 'USR_CHIP_NUMBER' => null, 'USR_TIME' => null, 'USR_PPS_FORM' => null],  // ROUSSEAU Marc
        ]);

        DB::statement('PRAGMA foreign_keys = ON');
    }
}

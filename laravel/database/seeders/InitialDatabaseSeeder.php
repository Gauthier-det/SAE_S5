<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InitialDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('SAN_ADDRESSES')->insert([
            ['ADD_ID' => 1, 'ADD_POSTAL_CODE' => 50100, 'ADD_CITY' => 'Cherbourg-en-Cotentin', 'ADD_STREET_NAME' => 'Rue des Marins', 'ADD_STREET_NUMBER' => '12'],
            ['ADD_ID' => 2, 'ADD_POSTAL_CODE' => 50100, 'ADD_CITY' => 'Alençon', 'ADD_STREET_NAME' => 'Rue Victor Hugo', 'ADD_STREET_NUMBER' => '5'],
            ['ADD_ID' => 3, 'ADD_POSTAL_CODE' => 14000, 'ADD_CITY' => 'Caen', 'ADD_STREET_NAME' => 'Avenue des Sports', 'ADD_STREET_NUMBER' => '7'],
            ['ADD_ID' => 4, 'ADD_POSTAL_CODE' => 76790, 'ADD_CITY' => 'Étretat', 'ADD_STREET_NAME' => 'Rue des Falaises', 'ADD_STREET_NUMBER' => '3'],
            ['ADD_ID' => 5, 'ADD_POSTAL_CODE' => 75010, 'ADD_CITY' => 'Paris', 'ADD_STREET_NAME' => 'Rue de Paris', 'ADD_STREET_NUMBER' => '21'],
            ['ADD_ID' => 6, 'ADD_POSTAL_CODE' => 75009, 'ADD_CITY' => 'Paris', 'ADD_STREET_NAME' => 'Rue Lafayette', 'ADD_STREET_NUMBER' => '14'],
            ['ADD_ID' => 7, 'ADD_POSTAL_CODE' => 50110, 'ADD_CITY' => 'Tourlaville', 'ADD_STREET_NAME' => 'Rue des Mielles', 'ADD_STREET_NUMBER' => '10'],
            ['ADD_ID' => 8, 'ADD_POSTAL_CODE' => 50760, 'ADD_CITY' => 'Barfleur', 'ADD_STREET_NAME' => 'Rue du Port', 'ADD_STREET_NUMBER' => '3'],
            ['ADD_ID' => 9, 'ADD_POSTAL_CODE' => 76000, 'ADD_CITY' => 'Rouen', 'ADD_STREET_NAME' => 'Rue des Arts', 'ADD_STREET_NUMBER' => '11'],
            ['ADD_ID' => 10, 'ADD_POSTAL_CODE' => 76600, 'ADD_CITY' => 'Le Havre', 'ADD_STREET_NAME' => 'Rue de la République', 'ADD_STREET_NUMBER' => '6'],
            ['ADD_ID' => 11, 'ADD_POSTAL_CODE' => 14100, 'ADD_CITY' => 'Lisieux', 'ADD_STREET_NAME' => 'Rue des Lilas', 'ADD_STREET_NUMBER' => '9'],
            ['ADD_ID' => 12, 'ADD_POSTAL_CODE' => 14400, 'ADD_CITY' => 'Bayeux', 'ADD_STREET_NAME' => 'Rue des Jardins', 'ADD_STREET_NUMBER' => '3'],
            ['ADD_ID' => 13, 'ADD_POSTAL_CODE' => 14510, 'ADD_CITY' => 'Houlgate', 'ADD_STREET_NAME' => 'Rue du Casino', 'ADD_STREET_NUMBER' => '4'],
            ['ADD_ID' => 14, 'ADD_POSTAL_CODE' => 50120, 'ADD_CITY' => 'Équeurdreville', 'ADD_STREET_NAME' => 'Rue des Poètes', 'ADD_STREET_NUMBER' => '2'],
            ['ADD_ID' => 15, 'ADD_POSTAL_CODE' => 75000, 'ADD_CITY' => 'Paris', 'ADD_STREET_NAME' => null, 'ADD_STREET_NUMBER' => null],
            ['ADD_ID' => 16, 'ADD_POSTAL_CODE' => 14123, 'ADD_CITY' => 'Ifs', 'ADD_STREET_NAME' => 'Rue des platanes', 'ADD_STREET_NUMBER' => '25'],
        ]);

        DB::table('SAN_CATEGORIES')->insert([
            ['CAT_ID' => 1, 'CAT_LABEL' => 'Mineur'],
            ['CAT_ID' => 2, 'CAT_LABEL' => 'Majeur non licencié'],
            ['CAT_ID' => 3, 'CAT_LABEL' => 'Licensié'],
        ]);

        DB::table('SAN_ROLES')->insert([
            ['ROL_ID' => 1, 'ROL_NAME' => 'Coureur'],
            ['ROL_ID' => 2, 'ROL_NAME' => 'Gestionnaire de site'],
        ]);

        $hashedPassword = Hash::make('pwd123');

        DB::table('SAN_USERS')->insert([
            ['USE_ID' => 1, 'ADD_ID' => 1, 'CLU_ID' => null, 'USE_MAIL' => 'admin.site@example.com', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Admin', 'USE_LAST_NAME' => 'Site', 'USE_GENDER' => 'Autre', 'USE_BIRTHDATE' => '1980-01-01', 'USE_PHONE_NUMBER' => 610000001, 'USE_LICENCE_NUMBER' => null, 'USE_MEMBERSHIP_DATE' => null, 'USE_VALIDITY' => '2020-01-01'],
            ['USE_ID' => 2, 'ADD_ID' => 2, 'CLU_ID' => null, 'USE_MAIL' => 'marc.marquez@example.com', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Marc', 'USE_LAST_NAME' => 'Marquez', 'USE_GENDER' => 'Homme', 'USE_BIRTHDATE' => '1985-05-10', 'USE_PHONE_NUMBER' => 610000002, 'USE_LICENCE_NUMBER' => 100002, 'USE_MEMBERSHIP_DATE' => '2022-01-01', 'USE_VALIDITY' => '2020-11-12'],
            ['USE_ID' => 3, 'ADD_ID' => 3, 'CLU_ID' => null, 'USE_MAIL' => 'fabio.quartararo@example.com', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Fabio', 'USE_LAST_NAME' => 'Quartararo', 'USE_GENDER' => 'Homme', 'USE_BIRTHDATE' => '1978-03-15', 'USE_PHONE_NUMBER' => 610000003, 'USE_LICENCE_NUMBER' => 100003, 'USE_MEMBERSHIP_DATE' => '2022-01-01', 'USE_VALIDITY' => '2021-01-13'],
            ['USE_ID' => 4, 'ADD_ID' => 2, 'CLU_ID' => null, 'USE_MAIL' => 'loane.kante@example.com', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Loane', 'USE_LAST_NAME' => 'Kante', 'USE_GENDER' => 'Femme', 'USE_BIRTHDATE' => '2000-05-10', 'USE_PHONE_NUMBER' => 610000004, 'USE_LICENCE_NUMBER' => 100006, 'USE_MEMBERSHIP_DATE' => '2023-01-01', 'USE_VALIDITY' => '2021-06-30'],
            ['USE_ID' => 5, 'ADD_ID' => 3, 'CLU_ID' => null, 'USE_MAIL' => 'jack.sparrow@example.com', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Jack', 'USE_LAST_NAME' => 'Sparrow', 'USE_GENDER' => 'Homme', 'USE_BIRTHDATE' => '1978-03-15', 'USE_PHONE_NUMBER' => 610000005, 'USE_LICENCE_NUMBER' => 100007, 'USE_MEMBERSHIP_DATE' => '2023-01-01', 'USE_VALIDITY' => '2022-06-07'],
            ['USE_ID' => 6, 'ADD_ID' => 3, 'CLU_ID' => null, 'USE_MAIL' => 'danielle.june.marsh@example.com', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Danielle', 'USE_LAST_NAME' => 'Marsh', 'USE_GENDER' => 'Femme', 'USE_BIRTHDATE' => '2005-03-11', 'USE_PHONE_NUMBER' => 610000722, 'USE_LICENCE_NUMBER' => 100722, 'USE_MEMBERSHIP_DATE' => '2022-01-01', 'USE_VALIDITY' => '2021-12-31'],
            ['USE_ID' => 7, 'ADD_ID' => 4, 'CLU_ID' => null, 'USE_MAIL' => 'alice.durand@example.com', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Alice', 'USE_LAST_NAME' => 'Durand', 'USE_GENDER' => 'Femme', 'USE_BIRTHDATE' => '1990-06-01', 'USE_PHONE_NUMBER' => 620000004, 'USE_LICENCE_NUMBER' => 200001, 'USE_MEMBERSHIP_DATE' => '2023-01-01', 'USE_VALIDITY' => '2022-02-16'],
            ['USE_ID' => 8, 'ADD_ID' => 5, 'CLU_ID' => null, 'USE_MAIL' => 'bob.douglas@example.com', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Bob', 'USE_LAST_NAME' => 'Douglas', 'USE_GENDER' => 'Homme', 'USE_BIRTHDATE' => '1992-02-01', 'USE_PHONE_NUMBER' => 620000005, 'USE_LICENCE_NUMBER' => 200002, 'USE_MEMBERSHIP_DATE' => '2023-01-01', 'USE_VALIDITY' => '2022-02-28'],
            ['USE_ID' => 9, 'ADD_ID' => 6, 'CLU_ID' => null, 'USE_MAIL' => 'hugo.dialo@example.com', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Hugo', 'USE_LAST_NAME' => 'Dialo', 'USE_GENDER' => 'Homme', 'USE_BIRTHDATE' => '1995-09-15', 'USE_PHONE_NUMBER' => 620000006, 'USE_LICENCE_NUMBER' => 200003, 'USE_MEMBERSHIP_DATE' => '2023-01-01', 'USE_VALIDITY' => '2021-03-09'],
            ['USE_ID' => 10, 'ADD_ID' => 7, 'CLU_ID' => null, 'USE_MAIL' => 'ino.casablanca@example.com', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Ino', 'USE_LAST_NAME' => 'Casablanca', 'USE_GENDER' => 'Homme', 'USE_BIRTHDATE' => '1993-04-30', 'USE_PHONE_NUMBER' => 620000008, 'USE_LICENCE_NUMBER' => 200005, 'USE_MEMBERSHIP_DATE' => '2023-01-01', 'USE_VALIDITY' => '2020-07-18'],
            ['USE_ID' => 11, 'ADD_ID' => 8, 'CLU_ID' => null, 'USE_MAIL' => 'cassiopee.guerdat@example.com', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Cassiopée', 'USE_LAST_NAME' => 'Guerdat', 'USE_GENDER' => 'Autre', 'USE_BIRTHDATE' => '1991-11-20', 'USE_PHONE_NUMBER' => 620000007, 'USE_LICENCE_NUMBER' => 200009, 'USE_MEMBERSHIP_DATE' => '2023-01-01', 'USE_VALIDITY' => '2022-08-31'],
            ['USE_ID' => 12, 'ADD_ID' => 2, 'CLU_ID' => null, 'USE_MAIL' => 'paul.dorbec@example.com', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Paul', 'USE_LAST_NAME' => 'Dorbec', 'USE_GENDER' => 'Homme', 'USE_BIRTHDATE' => '1990-01-05', 'USE_PHONE_NUMBER' => 620000052, 'USE_LICENCE_NUMBER' => 200012, 'USE_MEMBERSHIP_DATE' => '2023-01-01', 'USE_VALIDITY' => '2022-08-31'],
            ['USE_ID' => 13, 'ADD_ID' => 14, 'CLU_ID' => null, 'USE_MAIL' => 'yanis.enmieux@example.com', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Yanis', 'USE_LAST_NAME' => 'En Mieux', 'USE_GENDER' => 'Homme', 'USE_BIRTHDATE' => '1995-09-25', 'USE_PHONE_NUMBER' => 620000045, 'USE_LICENCE_NUMBER' => 200016, 'USE_MEMBERSHIP_DATE' => '2023-01-01', 'USE_VALIDITY' => '2021-08-31'],
            ['USE_ID' => 14, 'ADD_ID' => 10, 'CLU_ID' => null, 'USE_MAIL' => 'claire.dupont@example.com', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Claire', 'USE_LAST_NAME' => 'Dupont', 'USE_GENDER' => 'Femme', 'USE_BIRTHDATE' => '1987-06-12', 'USE_PHONE_NUMBER' => 620000020, 'USE_LICENCE_NUMBER' => 200020, 'USE_MEMBERSHIP_DATE' => '2022-01-01', 'USE_VALIDITY' => '2024-12-31'],
            ['USE_ID' => 15, 'ADD_ID' => 11, 'CLU_ID' => null, 'USE_MAIL' => 'julien.martin@example.com', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Julien', 'USE_LAST_NAME' => 'Martin', 'USE_GENDER' => 'Homme', 'USE_BIRTHDATE' => '1989-03-22', 'USE_PHONE_NUMBER' => 620000021, 'USE_LICENCE_NUMBER' => 200021, 'USE_MEMBERSHIP_DATE' => '2022-01-01', 'USE_VALIDITY' => '2024-12-31'],
            ['USE_ID' => 16, 'ADD_ID' => 12, 'CLU_ID' => null, 'USE_MAIL' => 'julie.garnier@example.com', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Julie', 'USE_LAST_NAME' => 'Garnier', 'USE_GENDER' => 'Femme', 'USE_BIRTHDATE' => '2005-08-15', 'USE_PHONE_NUMBER' => 620000022, 'USE_LICENCE_NUMBER' => null, 'USE_MEMBERSHIP_DATE' => null, 'USE_VALIDITY' => null],
            ['USE_ID' => 17, 'ADD_ID' => 13, 'CLU_ID' => null, 'USE_MAIL' => 'sylvian.delhoumi@example.com', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Sylvian', 'USE_LAST_NAME' => 'Delhoumi', 'USE_GENDER' => 'Homme', 'USE_BIRTHDATE' => '1985-11-10', 'USE_PHONE_NUMBER' => 620000023, 'USE_LICENCE_NUMBER' => 200023, 'USE_MEMBERSHIP_DATE' => '2023-01-01', 'USE_VALIDITY' => '2024-12-31'],
            ['USE_ID' => 18, 'ADD_ID' => 14, 'CLU_ID' => null, 'USE_MAIL' => 'anne@example.com', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Pierre', 'USE_LAST_NAME' => 'Anne', 'USE_GENDER' => 'Homme', 'USE_BIRTHDATE' => '1990-04-05', 'USE_PHONE_NUMBER' => 620000024, 'USE_LICENCE_NUMBER' => 200024, 'USE_MEMBERSHIP_DATE' => '2023-01-01', 'USE_VALIDITY' => '2024-12-31'],
            ['USE_ID' => 19, 'ADD_ID' => 15, 'CLU_ID' => null, 'USE_MAIL' => 'jacquier@example.com', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Thomas', 'USE_LAST_NAME' => 'Jacquier', 'USE_GENDER' => 'Homme', 'USE_BIRTHDATE' => '2015-01-01', 'USE_PHONE_NUMBER' => 620000025, 'USE_LICENCE_NUMBER' => 200025, 'USE_MEMBERSHIP_DATE' => '2023-01-01', 'USE_VALIDITY' => '2024-12-31'],
            ['USE_ID' => 20, 'ADD_ID' => 9, 'CLU_ID' => null, 'USE_MAIL' => 'coureur.sansclub@example.com', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Chloe', 'USE_LAST_NAME' => 'Libre', 'USE_GENDER' => 'Femme', 'USE_BIRTHDATE' => '1998-01-10', 'USE_PHONE_NUMBER' => 620000009, 'USE_LICENCE_NUMBER' => null, 'USE_MEMBERSHIP_DATE' => null, 'USE_VALIDITY' => null],
            ['USE_ID' => 21, 'ADD_ID' => 10, 'CLU_ID' => null, 'USE_MAIL' => 'lea.caron@example.com', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Léa', 'USE_LAST_NAME' => 'Caron', 'USE_GENDER' => 'Femme', 'USE_BIRTHDATE' => '1995-07-14', 'USE_PHONE_NUMBER' => 620000026, 'USE_LICENCE_NUMBER' => 200026, 'USE_MEMBERSHIP_DATE' => '2023-01-01', 'USE_VALIDITY' => '2024-12-31'],
            ['USE_ID' => 22, 'ADD_ID' => 11, 'CLU_ID' => null, 'USE_MAIL' => 'lugnier@example.com', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Marie', 'USE_LAST_NAME' => 'Lugnier', 'USE_GENDER' => 'Femme', 'USE_BIRTHDATE' => '1982-09-30', 'USE_PHONE_NUMBER' => 620000027, 'USE_LICENCE_NUMBER' => 200027, 'USE_MEMBERSHIP_DATE' => '2022-01-01', 'USE_VALIDITY' => '2024-12-31'],
            ['USE_ID' => 23, 'ADD_ID' => 12, 'CLU_ID' => null, 'USE_MAIL' => 'clara.dumont@example.com', 'USE_PASSWORD' => $hashedPassword, 'USE_NAME' => 'Clara', 'USE_LAST_NAME' => 'Dumont', 'USE_GENDER' => 'Femme', 'USE_BIRTHDATE' => '1988-12-05', 'USE_PHONE_NUMBER' => 620000028, 'USE_LICENCE_NUMBER' => 200028, 'USE_MEMBERSHIP_DATE' => '2023-01-01', 'USE_VALIDITY' => '2024-12-31'],
]);

        DB::table('SAN_CLUBS')->insert([
            ['CLU_ID' => 1, 'USE_ID' => 2, 'ADD_ID' => 1, 'CLU_NAME' => 'CO-DE'],
            ['CLU_ID' => 2, 'USE_ID' => 3, 'ADD_ID' => 3, 'CLU_NAME' => "L'Embuscade"],
            ['CLU_ID' => 3, 'USE_ID' => 13, 'ADD_ID' => 5, 'CLU_NAME' => 'CO AZIMUT 77'],
            ['CLU_ID' => 4, 'USE_ID' => 22, 'ADD_ID' => 11, 'CLU_NAME' => 'Club Existant Lugnier'],
        ]);

        DB::table('SAN_USERS')->whereIn('USE_ID', [2, 4, 7, 8, 9])->update(['CLU_ID' => 1]);
        DB::table('SAN_USERS')->whereIn('USE_ID', [3, 5, 6, 10, 11])->update(['CLU_ID' => 2]);
        DB::table('SAN_USERS')->whereIn('USE_ID', [12, 14, 15])->update(['CLU_ID' => 3]);
        DB::table('SAN_USERS')->where('USE_ID', 22)->update(['CLU_ID' => 4]);

        DB::table('SAN_ROLES_USERS')->insert([
            ['USE_ID' => 1, 'ROL_ID' => 2],
        ]);

        DB::table('SAN_RAIDS')->insert([
            ['RAI_ID' => 1, 'CLU_ID' => 1, 'ADD_ID' => 7, 'USE_ID' => 4, 'RAI_NB_RACES' => 5, 'RAI_NAME' => 'Raid Cotentin 2026', 'RAI_MAIL' => 'contact@raidcotentin.fr', 'RAI_PHONE_NUMBER' => null, 'RAI_WEB_SITE' => 'https://raidcotentin.fr', 'RAI_IMAGE' => 'raid_cotentin.jpg', 'RAI_TIME_START' => '2025-10-10 08:00:00', 'RAI_TIME_END' => '2025-10-10 20:00:00', 'RAI_REGISTRATION_START' => '2025-09-01 00:00:00', 'RAI_REGISTRATION_END' => '2026-09-30 23:59:59'],
            ['RAI_ID' => 2, 'CLU_ID' => 2, 'ADD_ID' => 4, 'USE_ID' => 5, 'RAI_NB_RACES' => 5, 'RAI_NAME' => 'Raid de Vanves 2025', 'RAI_MAIL' => 'contact@trailvanves.fr', 'RAI_PHONE_NUMBER' => null, 'RAI_WEB_SITE' => 'https://trailfalaises.fr', 'RAI_IMAGE' => 'trail_falaises.jpg', 'RAI_TIME_START' => '2026-04-20 07:30:00', 'RAI_TIME_END' => '2026-04-20 19:00:00', 'RAI_REGISTRATION_START' => '2025-12-01 00:00:00', 'RAI_REGISTRATION_END' => '2026-04-15 23:59:59'],
            ['RAI_ID' => 3, 'CLU_ID' => 3, 'ADD_ID' => 2, 'USE_ID' => 12, 'RAI_NB_RACES' => 4, 'RAI_NAME' => 'RAID OBIWAK', 'RAI_MAIL' => 'contact@obiwak.raid.fr', 'RAI_PHONE_NUMBER' => null, 'RAI_WEB_SITE' => 'https://obiwak_raid.fr', 'RAI_IMAGE' => 'trail_falaises.jpg', 'RAI_TIME_START' => '2026-08-20 07:30:00', 'RAI_TIME_END' => '2026-08-20 19:00:00', 'RAI_REGISTRATION_START' => '2026-04-01 00:00:00', 'RAI_REGISTRATION_END' => '2026-04-30 23:59:59'],
        ]);

        DB::table('SAN_RACES')->insert([
            ['RAC_ID' => 1, 'USE_ID' => 4, 'RAI_ID' => 1, 'RAC_NAME' => 'Trail Mixte Loisir', 'RAC_TIME_START' => '2025-10-10 08:30:00', 'RAC_TIME_END' => '2025-10-10 13:30:00', 'RAC_GENDER' => 'Mixte', 'RAC_TYPE' => 'Loisir', 'RAC_DIFFICULTY' => 'Moyen', 'RAC_MIN_PARTICIPANTS' => 5, 'RAC_MAX_PARTICIPANTS' => 200, 'RAC_MIN_TEAMS' => 2, 'RAC_MAX_TEAMS' => 50, 'RAC_MAX_TEAM_MEMBERS' => 3, 'RAC_AGE_MIN' => 12, 'RAC_AGE_MIDDLE' => 15, 'RAC_AGE_MAX' => 18, 'RAC_CHIP_MANDATORY' => 0],
            ['RAC_ID' => 2, 'USE_ID' => 4, 'RAI_ID' => 1, 'RAC_NAME' => 'Trail Hommes Compétitif', 'RAC_TIME_START' => '2025-10-10 12:30:00', 'RAC_TIME_END' => '2025-10-10 18:30:00', 'RAC_GENDER' => 'Homme', 'RAC_TYPE' => 'Compétitif', 'RAC_DIFFICULTY' => 'Difficile', 'RAC_MIN_PARTICIPANTS' => 4, 'RAC_MAX_PARTICIPANTS' => 150, 'RAC_MIN_TEAMS' => 2, 'RAC_MAX_TEAMS' => 40, 'RAC_MAX_TEAM_MEMBERS' => 2, 'RAC_AGE_MIN' => 18, 'RAC_AGE_MIDDLE' => 25, 'RAC_AGE_MAX' => 30, 'RAC_CHIP_MANDATORY' => 1],
            ['RAC_ID' => 3, 'USE_ID' => 6, 'RAI_ID' => 2, 'RAC_NAME' => 'Trail Femmes Compétitif', 'RAC_TIME_START' => '2026-06-15 09:15:00', 'RAC_TIME_END' => '2026-06-15 13:15:00', 'RAC_GENDER' => 'Femme', 'RAC_TYPE' => 'Competitif', 'RAC_DIFFICULTY' => 'Moyen', 'RAC_MIN_PARTICIPANTS' => 6, 'RAC_MAX_PARTICIPANTS' => 120, 'RAC_MIN_TEAMS' => 2, 'RAC_MAX_TEAMS' => 30, 'RAC_MAX_TEAM_MEMBERS' => 3, 'RAC_AGE_MIN' => 10, 'RAC_AGE_MIDDLE' => 18, 'RAC_AGE_MAX' => 20, 'RAC_CHIP_MANDATORY' => 1],
            ['RAC_ID' => 4, 'USE_ID' => 8, 'RAI_ID' => 2, 'RAC_NAME' => 'Trail Hommes Loisir', 'RAC_TIME_START' => '2026-04-20 08:00:00', 'RAC_TIME_END' => '2026-04-20 11:30:00', 'RAC_GENDER' => 'Homme', 'RAC_TYPE' => 'Loisir', 'RAC_DIFFICULTY' => 'Facile', 'RAC_MIN_PARTICIPANTS' => 4, 'RAC_MAX_PARTICIPANTS' => 300, 'RAC_MIN_TEAMS' => 2, 'RAC_MAX_TEAMS' => 60, 'RAC_MAX_TEAM_MEMBERS' => 2, 'RAC_AGE_MIN' => 14, 'RAC_AGE_MIDDLE' => 17, 'RAC_AGE_MAX' => 19, 'RAC_CHIP_MANDATORY' => 1],
            ['RAC_ID' => 5, 'USE_ID' => 15, 'RAI_ID' => 3, 'RAC_NAME' => 'PARCOURS B', 'RAC_TIME_START' => '2026-08-20 09:00:00', 'RAC_TIME_END' => '2026-08-20 12:00:00', 'RAC_GENDER' => 'Mixte', 'RAC_TYPE' => 'Competitif', 'RAC_DIFFICULTY' => 'Moyen', 'RAC_MIN_PARTICIPANTS' => 4, 'RAC_MAX_PARTICIPANTS' => 100, 'RAC_MIN_TEAMS' => 2, 'RAC_MAX_TEAMS' => 25, 'RAC_MAX_TEAM_MEMBERS' => 3, 'RAC_AGE_MIN' => 16, 'RAC_AGE_MIDDLE' => 25, 'RAC_AGE_MAX' => 35, 'RAC_CHIP_MANDATORY' => 1],
            ['RAC_ID' => 6, 'USE_ID' => 15, 'RAI_ID' => 3, 'RAC_NAME' => 'LUTIN', 'RAC_TIME_START' => '2026-08-20 10:00:00', 'RAC_TIME_END' => '2026-08-20 11:30:00', 'RAC_GENDER' => 'Mixte', 'RAC_TYPE' => 'Loisir', 'RAC_DIFFICULTY' => 'Facile', 'RAC_MIN_PARTICIPANTS' => 5, 'RAC_MAX_PARTICIPANTS' => 150, 'RAC_MIN_TEAMS' => 2, 'RAC_MAX_TEAMS' => 40, 'RAC_MAX_TEAM_MEMBERS' => 4, 'RAC_AGE_MIN' => 10, 'RAC_AGE_MIDDLE' => 15, 'RAC_AGE_MAX' => 18, 'RAC_CHIP_MANDATORY' => 0],
        ]);

        DB::table('SAN_CATEGORIES_RACES')->insert([
            ['RAC_ID' => 1, 'CAT_ID' => 1, 'CAR_PRICE' => 8.00],
            ['RAC_ID' => 1, 'CAT_ID' => 2, 'CAR_PRICE' => 12.00],
            ['RAC_ID' => 1, 'CAT_ID' => 3, 'CAR_PRICE' => 7.00],
            ['RAC_ID' => 2, 'CAT_ID' => 1, 'CAR_PRICE' => 4.00],
            ['RAC_ID' => 2, 'CAT_ID' => 2, 'CAR_PRICE' => 7.00],
            ['RAC_ID' => 2, 'CAT_ID' => 3, 'CAR_PRICE' => 4.00],
            ['RAC_ID' => 3, 'CAT_ID' => 1, 'CAR_PRICE' => 10.00],
            ['RAC_ID' => 3, 'CAT_ID' => 2, 'CAR_PRICE' => 15.00],
            ['RAC_ID' => 3, 'CAT_ID' => 3, 'CAR_PRICE' => 7.50],
            ['RAC_ID' => 4, 'CAT_ID' => 1, 'CAR_PRICE' => 6.00],
            ['RAC_ID' => 4, 'CAT_ID' => 2, 'CAR_PRICE' => 8.00],
            ['RAC_ID' => 4, 'CAT_ID' => 3, 'CAR_PRICE' => 6.00],
            ['RAC_ID' => 5, 'CAT_ID' => 1, 'CAR_PRICE' => 9.00],
            ['RAC_ID' => 5, 'CAT_ID' => 2, 'CAR_PRICE' => 14.00],
            ['RAC_ID' => 5, 'CAT_ID' => 3, 'CAR_PRICE' => 8.00],
            ['RAC_ID' => 6, 'CAT_ID' => 1, 'CAR_PRICE' => 5.00],
            ['RAC_ID' => 6, 'CAT_ID' => 2, 'CAR_PRICE' => 9.00],
            ['RAC_ID' => 6, 'CAT_ID' => 3, 'CAR_PRICE' => 5.00],
        ]);

        DB::table('SAN_TEAMS')->insert([
            ['TEA_ID' => 1, 'USE_ID' => 2, 'TEA_NAME' => 'Lunatic', 'TEA_IMAGE' => null],
            ['TEA_ID' => 2, 'USE_ID' => 7, 'TEA_NAME' => 'Arsenik', 'TEA_IMAGE' => null],
            ['TEA_ID' => 3, 'USE_ID' => 10, 'TEA_NAME' => 'Arctic Mokeys', 'TEA_IMAGE' => null],
            ['TEA_ID' => 4, 'USE_ID' => 6, 'TEA_NAME' => 'NewJeans', 'TEA_IMAGE' => null],
            ['TEA_ID' => 5, 'USE_ID' => 21, 'TEA_NAME' => 'Équipe Léa', 'TEA_IMAGE' => null],
            ['TEA_ID' => 6, 'USE_ID' => 16, 'TEA_NAME' => 'SIMPLET', 'TEA_IMAGE' => null],
        ]);

        DB::table('SAN_USERS_TEAMS')->insert([
            ['USE_ID' => 7, 'TEA_ID' => 1],
            ['USE_ID' => 8, 'TEA_ID' => 1],
            ['USE_ID' => 9, 'TEA_ID' => 1],
            ['USE_ID' => 10, 'TEA_ID' => 2],
            ['USE_ID' => 11, 'TEA_ID' => 2],
            ['USE_ID' => 7, 'TEA_ID' => 3],
            ['USE_ID' => 8, 'TEA_ID' => 3],
            ['USE_ID' => 9, 'TEA_ID' => 3],
            ['USE_ID' => 10, 'TEA_ID' => 4],
            ['USE_ID' => 3, 'TEA_ID' => 4],
            ['USE_ID' => 21, 'TEA_ID' => 5],
            ['USE_ID' => 16, 'TEA_ID' => 6],
        ]);

        DB::table('SAN_TEAMS_RACES')->insert([
            ['TEA_ID' => 1, 'RAC_ID' => 1, 'TER_TIME' => '02:45:30', 'TER_IS_VALID' => 1, 'TER_RACE_NUMBER' => 101],
            ['TEA_ID' => 3, 'RAC_ID' => 1, 'TER_TIME' => '01:55:00', 'TER_IS_VALID' => 1, 'TER_RACE_NUMBER' => 402],
            ['TEA_ID' => 2, 'RAC_ID' => 2, 'TER_TIME' => '02:50:10', 'TER_IS_VALID' => 1, 'TER_RACE_NUMBER' => 102],
            ['TEA_ID' => 4, 'RAC_ID' => 2, 'TER_TIME' => '02:45:12', 'TER_IS_VALID' => 1, 'TER_RACE_NUMBER' => 501],
            ['TEA_ID' => 1, 'RAC_ID' => 3, 'TER_TIME' => null, 'TER_IS_VALID' => 1, 'TER_RACE_NUMBER' => 103],
            ['TEA_ID' => 3, 'RAC_ID' => 3, 'TER_TIME' => null, 'TER_IS_VALID' => 1, 'TER_RACE_NUMBER' => 502],
            ['TEA_ID' => 2, 'RAC_ID' => 4, 'TER_TIME' => null, 'TER_IS_VALID' => 1, 'TER_RACE_NUMBER' => 201],
            ['TEA_ID' => 4, 'RAC_ID' => 4, 'TER_TIME' => null, 'TER_IS_VALID' => 1, 'TER_RACE_NUMBER' => 601],
            ['TEA_ID' => 5, 'RAC_ID' => 5, 'TER_TIME' => null, 'TER_IS_VALID' => 1, 'TER_RACE_NUMBER' => 301],
            ['TEA_ID' => 6, 'RAC_ID' => 5, 'TER_TIME' => null, 'TER_IS_VALID' => 1, 'TER_RACE_NUMBER' => 302],
        ]);

        DB::table('SAN_USERS_RACES')->insert([
            ['USE_ID' => 7, 'RAC_ID' => 1, 'USR_TIME' => 165.50, 'USR_CHIP_NUMBER' => 1001, 'USR_PPS_FORM' => null],
            ['USE_ID' => 8, 'RAC_ID' => 1, 'USR_TIME' => 170.20, 'USR_CHIP_NUMBER' => 1002, 'USR_PPS_FORM' => null],
            ['USE_ID' => 9, 'RAC_ID' => 1, 'USR_TIME' => 165.50, 'USR_CHIP_NUMBER' => 1001, 'USR_PPS_FORM' => 'hugo_pps.pdf'],
            ['USE_ID' => 10, 'RAC_ID' => 1, 'USR_TIME' => 170.20, 'USR_CHIP_NUMBER' => 1002, 'USR_PPS_FORM' => null],
            ['USE_ID' => 11, 'RAC_ID' => 1, 'USR_TIME' => 165.50, 'USR_CHIP_NUMBER' => 1001, 'USR_PPS_FORM' => null],
            ['USE_ID' => 7, 'RAC_ID' => 2, 'USR_TIME' => 295.56, 'USR_CHIP_NUMBER' => 1003, 'USR_PPS_FORM' => null],
            ['USE_ID' => 8, 'RAC_ID' => 2, 'USR_TIME' => 310.30, 'USR_CHIP_NUMBER' => 1004, 'USR_PPS_FORM' => null],
            ['USE_ID' => 10, 'RAC_ID' => 2, 'USR_TIME' => 295.56, 'USR_CHIP_NUMBER' => 1003, 'USR_PPS_FORM' => null],
            ['USE_ID' => 3, 'RAC_ID' => 2, 'USR_TIME' => 310.30, 'USR_CHIP_NUMBER' => 1004, 'USR_PPS_FORM' => null],
            ['USE_ID' => 7, 'RAC_ID' => 3, 'USR_TIME' => 185.29, 'USR_CHIP_NUMBER' => 1005, 'USR_PPS_FORM' => null],
            ['USE_ID' => 8, 'RAC_ID' => 3, 'USR_TIME' => 190.10, 'USR_CHIP_NUMBER' => 1006, 'USR_PPS_FORM' => null],
            ['USE_ID' => 9, 'RAC_ID' => 3, 'USR_TIME' => 185.29, 'USR_CHIP_NUMBER' => 1005, 'USR_PPS_FORM' => null],
            ['USE_ID' => 10, 'RAC_ID' => 3, 'USR_TIME' => 190.10, 'USR_CHIP_NUMBER' => 1006, 'USR_PPS_FORM' => null],
            ['USE_ID' => 11, 'RAC_ID' => 3, 'USR_TIME' => 185.29, 'USR_CHIP_NUMBER' => 1005, 'USR_PPS_FORM' => null],
            ['USE_ID' => 7, 'RAC_ID' => 4, 'USR_TIME' => 120.50, 'USR_CHIP_NUMBER' => 1007, 'USR_PPS_FORM' => null],
            ['USE_ID' => 8, 'RAC_ID' => 4, 'USR_TIME' => 118.40, 'USR_CHIP_NUMBER' => 1008, 'USR_PPS_FORM' => null],
            ['USE_ID' => 10, 'RAC_ID' => 4, 'USR_TIME' => 120.50, 'USR_CHIP_NUMBER' => 1007, 'USR_PPS_FORM' => null],
            ['USE_ID' => 3, 'RAC_ID' => 4, 'USR_TIME' => 118.40, 'USR_CHIP_NUMBER' => 1008, 'USR_PPS_FORM' => null],
            ['USE_ID' => 21, 'RAC_ID' => 5, 'USR_TIME' => null, 'USR_CHIP_NUMBER' => null, 'USR_PPS_FORM' => null],
            ['USE_ID' => 16, 'RAC_ID' => 5, 'USR_TIME' => null, 'USR_CHIP_NUMBER' => null, 'USR_PPS_FORM' => null],
            ['USE_ID' => 18, 'RAC_ID' => 3, 'USR_TIME' => null, 'USR_CHIP_NUMBER' => null, 'USR_PPS_FORM' => null],
        ]);
    }
}

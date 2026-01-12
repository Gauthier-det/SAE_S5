DROP DATABASE IF EXISTS g13_db;

CREATE DATABASE IF NOT EXISTS g13_db;
USE g13_db;

-----------------------------------------------------------------------------

TABLE : SAN_USERS

-----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS SAN_USERS
(
USE_ID INTEGER NOT NULL ,
ADD_ID BIGINT(10) NOT NULL ,
CLU_ID INTEGER NULL ,
USE_MAIL CHAR(255) NOT NULL ,
USE_PASSWORD CHAR(255) NOT NULL ,
USE_NAME CHAR(255) NOT NULL ,
USE_LAST_NAME CHAR(255) NOT NULL ,
USE_BIRTHDATE DATE NULL ,
USE_PHONE_NUMBER INTEGER NULL ,
USE_LICENCE_NUMBER INTEGER NULL ,
USE_PPS_FORM CHAR(255) NULL ,
USE_MEMBERSHIP_DATE DATE NULL
, PRIMARY KEY (USE_ID)
)
comment = "";

-----------------------------------------------------------------------------

INDEX DE LA TABLE SAN_USERS

-----------------------------------------------------------------------------

CREATE INDEX I_FK_SAN_USERS_SAN_ADDRESSES
ON SAN_USERS (ADD_ID ASC);

CREATE INDEX I_FK_SAN_USERS_SAN_CLUBS
ON SAN_USERS (CLU_ID ASC);

-----------------------------------------------------------------------------

TABLE : SAN_TEAMS

-----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS SAN_TEAMS
(
TEA_ID INTEGER NOT NULL ,
USE_ID INTEGER NOT NULL ,
TEA_NAME CHAR(255) NOT NULL ,
TEA_IMAGE CHAR(255) NULL
, PRIMARY KEY (TEA_ID)
)
comment = "";

-----------------------------------------------------------------------------

INDEX DE LA TABLE SAN_TEAMS

-----------------------------------------------------------------------------

CREATE INDEX I_FK_SAN_TEAMS_SAN_USERS
ON SAN_TEAMS (USE_ID ASC);

-----------------------------------------------------------------------------

TABLE : SAN_CLUBS

-----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS SAN_CLUBS
(
CLU_ID INTEGER NOT NULL ,
USE_ID INTEGER NOT NULL ,
ADD_ID BIGINT(10) NOT NULL ,
CLU_NAME CHAR(255) NOT NULL
, PRIMARY KEY (CLU_ID)
)
comment = "";

-----------------------------------------------------------------------------

INDEX DE LA TABLE SAN_CLUBS

-----------------------------------------------------------------------------

CREATE INDEX I_FK_SAN_CLUBS_SAN_USERS
ON SAN_CLUBS (USE_ID ASC);

CREATE INDEX I_FK_SAN_CLUBS_SAN_ADDRESSES
ON SAN_CLUBS (ADD_ID ASC);

-----------------------------------------------------------------------------

TABLE : SAN_CATEGORIES

-----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS SAN_CATEGORIES
(
CAT_ID INTEGER NOT NULL ,
CAT_LABEL CHAR(32) NOT NULL
, PRIMARY KEY (CAT_ID)
)
comment = "";

-----------------------------------------------------------------------------

TABLE : SAN_ROLES

-----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS SAN_ROLES
(
ROL_ID INTEGER NOT NULL ,
ROL_NAME CHAR(255) NOT NULL
, PRIMARY KEY (ROL_ID)
)
comment = "";

-----------------------------------------------------------------------------

TABLE : SAN_RACES

-----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS SAN_RACES
(
RAC_ID INTEGER NOT NULL ,
USE_ID INTEGER NOT NULL ,
RAI_ID INTEGER NOT NULL ,
RAC_TIME_START DATETIME NOT NULL ,
RAC_TIME_END DATETIME NOT NULL ,
RAC_TYPE CHAR(255) NOT NULL ,
RAC_DIFFICULTY CHAR(255) NOT NULL ,
RAC_MIN_PARTICIPANTS BIGINT(4) NOT NULL ,
RAC_MAX_PARTICIPANTS BIGINT(4) NOT NULL ,
RAC_MIN_TEAMS BIGINT(4) NOT NULL ,
RAC_MAX_TEAMS BIGINT(4) NOT NULL ,
RAC_TEAM_MEMBERS BIGINT(4) NOT NULL ,
RAC_AGE_MIN BIGINT(4) NOT NULL ,
RAC_AGE_MIDDLE BIGINT(4) NOT NULL ,
RAC_AGE_MAX BIGINT(4) NOT NULL
, PRIMARY KEY (RAC_ID)
)
comment = "";

-----------------------------------------------------------------------------

INDEX DE LA TABLE SAN_RACES

-----------------------------------------------------------------------------

CREATE INDEX I_FK_SAN_RACES_SAN_USERS
ON SAN_RACES (USE_ID ASC);

CREATE INDEX I_FK_SAN_RACES_SAN_RAIDS
ON SAN_RACES (RAI_ID ASC);

-----------------------------------------------------------------------------

TABLE : SAN_RAIDS

-----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS SAN_RAIDS
(
RAI_ID INTEGER NOT NULL ,
CLU_ID INTEGER NOT NULL ,
ADD_ID BIGINT(10) NOT NULL ,
USE_ID INTEGER NOT NULL ,
RAI_NAME CHAR(255) NOT NULL ,
RAI_MAIL CHAR(255) NULL ,
RAI_PHONE_NUMBER CHAR(255) NULL ,
RAI_WEB_SITE CHAR(255) NULL ,
RAI_IMAGE CHAR(255) NULL ,
RAI_TIME_START DATETIME NOT NULL ,
RAI_TIME_END DATETIME NOT NULL ,
RAI_REGISTRATION_START DATETIME NOT NULL ,
RAI_REGISTRATION_END DATETIME NOT NULL
, PRIMARY KEY (RAI_ID)
)
comment = "";

-----------------------------------------------------------------------------

INDEX DE LA TABLE SAN_RAIDS

-----------------------------------------------------------------------------

CREATE INDEX I_FK_SAN_RAIDS_SAN_CLUBS
ON SAN_RAIDS (CLU_ID ASC);

CREATE INDEX I_FK_SAN_RAIDS_SAN_ADDRESSES
ON SAN_RAIDS (ADD_ID ASC);

CREATE INDEX I_FK_SAN_RAIDS_SAN_USERS
ON SAN_RAIDS (USE_ID ASC);

-----------------------------------------------------------------------------

TABLE : SAN_ADDRESSES

-----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS SAN_ADDRESSES
(
ADD_ID BIGINT(10) NOT NULL ,
ADD_POSTAL_CODE BIGINT(6) NOT NULL ,
ADD_CITY CHAR(255) NOT NULL ,
ADD_STREET_NAME CHAR(255) NOT NULL ,
ADD_STREET_NUMBER CHAR(8) NOT NULL
, PRIMARY KEY (ADD_ID)
)
comment = "";

-----------------------------------------------------------------------------

TABLE : SAN_USERS_TEAMS

-----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS SAN_USERS_TEAMS
(
USE_ID INTEGER NOT NULL ,
TEA_ID INTEGER NOT NULL
, PRIMARY KEY (USE_ID,TEA_ID)
)
comment = "";

-----------------------------------------------------------------------------

INDEX DE LA TABLE SAN_USERS_TEAMS

-----------------------------------------------------------------------------

CREATE INDEX I_FK_SAN_USERS_TEAMS_SAN_USERS
ON SAN_USERS_TEAMS (USE_ID ASC);

CREATE INDEX I_FK_SAN_USERS_TEAMS_SAN_TEAMS
ON SAN_USERS_TEAMS (TEA_ID ASC);

-----------------------------------------------------------------------------

TABLE : SAN_TEAMS_RACES

-----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS SAN_TEAMS_RACES
(
TEA_ID INTEGER NOT NULL ,
RAC_ID INTEGER NOT NULL ,
TER_TIME TIME NULL ,
TER_RACE_NUMBER INTEGER NOT NULL
, PRIMARY KEY (TEA_ID,RAC_ID)
)
comment = "";

-----------------------------------------------------------------------------

INDEX DE LA TABLE SAN_TEAMS_RACES

-----------------------------------------------------------------------------

CREATE INDEX I_FK_SAN_TEAMS_RACES_SAN_TEAMS
ON SAN_TEAMS_RACES (TEA_ID ASC);

CREATE INDEX I_FK_SAN_TEAMS_RACES_SAN_RACES
ON SAN_TEAMS_RACES (RAC_ID ASC);

-----------------------------------------------------------------------------

TABLE : SAN_ROLES_USERS

-----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS SAN_ROLES_USERS
(
USE_ID INTEGER NOT NULL ,
ROL_ID INTEGER NOT NULL
, PRIMARY KEY (USE_ID,ROL_ID)
)
comment = "";

-----------------------------------------------------------------------------

INDEX DE LA TABLE SAN_ROLES_USERS

-----------------------------------------------------------------------------

CREATE INDEX I_FK_SAN_ROLES_USERS_SAN_USERS
ON SAN_ROLES_USERS (USE_ID ASC);

CREATE INDEX I_FK_SAN_ROLES_USERS_SAN_ROLES
ON SAN_ROLES_USERS (ROL_ID ASC);

-----------------------------------------------------------------------------

TABLE : SAN_CATEGORIES_RACES

-----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS SAN_CATEGORIES_RACES
(
RAC_ID INTEGER NOT NULL ,
CAT_ID INTEGER NOT NULL ,
CAR_PRICE DECIMAL(10,2) NOT NULL
, PRIMARY KEY (RAC_ID,CAT_ID)
)
comment = "";

-----------------------------------------------------------------------------

INDEX DE LA TABLE SAN_CATEGORIES_RACES

-----------------------------------------------------------------------------

CREATE INDEX I_FK_SAN_CATEGORIES_RACES_SAN_RACES
ON SAN_CATEGORIES_RACES (RAC_ID ASC);

CREATE INDEX I_FK_SAN_CATEGORIES_RACES_SAN_CATEGORIES
ON SAN_CATEGORIES_RACES (CAT_ID ASC);

-----------------------------------------------------------------------------

TABLE : SAN_USERS_RACES

-----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS SAN_USERS_RACES
(
USE_ID INTEGER NOT NULL ,
RAC_ID INTEGER NOT NULL ,
USR_CHIP_NUMBER INTEGER NULL ,
USR_TIME DECIMAL(10,2) NULL
, PRIMARY KEY (USE_ID,RAC_ID)
)
comment = "";

-----------------------------------------------------------------------------

INDEX DE LA TABLE SAN_USERS_RACES

-----------------------------------------------------------------------------

CREATE INDEX I_FK_SAN_USERS_RACES_SAN_USERS
ON SAN_USERS_RACES (USE_ID ASC);

CREATE INDEX I_FK_SAN_USERS_RACES_SAN_RACES
ON SAN_USERS_RACES (RAC_ID ASC);

-----------------------------------------------------------------------------

CREATION DES REFERENCES DE TABLE

-----------------------------------------------------------------------------

ALTER TABLE SAN_USERS
ADD FOREIGN KEY FK_SAN_USERS_SAN_ADDRESSES (ADD_ID)
REFERENCES SAN_ADDRESSES (ADD_ID) ;

ALTER TABLE SAN_USERS
ADD FOREIGN KEY FK_SAN_USERS_SAN_CLUBS (CLU_ID)
REFERENCES SAN_CLUBS (CLU_ID) ;

ALTER TABLE SAN_TEAMS
ADD FOREIGN KEY FK_SAN_TEAMS_SAN_USERS (USE_ID)
REFERENCES SAN_USERS (USE_ID) ;

ALTER TABLE SAN_CLUBS
ADD FOREIGN KEY FK_SAN_CLUBS_SAN_USERS (USE_ID)
REFERENCES SAN_USERS (USE_ID) ;

ALTER TABLE SAN_CLUBS
ADD FOREIGN KEY FK_SAN_CLUBS_SAN_ADDRESSES (ADD_ID)
REFERENCES SAN_ADDRESSES (ADD_ID) ;

ALTER TABLE SAN_RACES
ADD FOREIGN KEY FK_SAN_RACES_SAN_USERS (USE_ID)
REFERENCES SAN_USERS (USE_ID) ;

ALTER TABLE SAN_RACES
ADD FOREIGN KEY FK_SAN_RACES_SAN_RAIDS (RAI_ID)
REFERENCES SAN_RAIDS (RAI_ID) ;

ALTER TABLE SAN_RAIDS
ADD FOREIGN KEY FK_SAN_RAIDS_SAN_CLUBS (CLU_ID)
REFERENCES SAN_CLUBS (CLU_ID) ;

ALTER TABLE SAN_RAIDS
ADD FOREIGN KEY FK_SAN_RAIDS_SAN_ADDRESSES (ADD_ID)
REFERENCES SAN_ADDRESSES (ADD_ID) ;

ALTER TABLE SAN_RAIDS
ADD FOREIGN KEY FK_SAN_RAIDS_SAN_USERS (USE_ID)
REFERENCES SAN_USERS (USE_ID) ;

ALTER TABLE SAN_USERS_TEAMS
ADD FOREIGN KEY FK_SAN_USERS_TEAMS_SAN_USERS (USE_ID)
REFERENCES SAN_USERS (USE_ID) ;

ALTER TABLE SAN_USERS_TEAMS
ADD FOREIGN KEY FK_SAN_USERS_TEAMS_SAN_TEAMS (TEA_ID)
REFERENCES SAN_TEAMS (TEA_ID) ;

ALTER TABLE SAN_TEAMS_RACES
ADD FOREIGN KEY FK_SAN_TEAMS_RACES_SAN_TEAMS (TEA_ID)
REFERENCES SAN_TEAMS (TEA_ID) ;

ALTER TABLE SAN_TEAMS_RACES
ADD FOREIGN KEY FK_SAN_TEAMS_RACES_SAN_RACES (RAC_ID)
REFERENCES SAN_RACES (RAC_ID) ;

ALTER TABLE SAN_ROLES_USERS
ADD FOREIGN KEY FK_SAN_ROLES_USERS_SAN_USERS (USE_ID)
REFERENCES SAN_USERS (USE_ID) ;

ALTER TABLE SAN_ROLES_USERS
ADD FOREIGN KEY FK_SAN_ROLES_USERS_SAN_ROLES (ROL_ID)
REFERENCES SAN_ROLES (ROL_ID) ;

ALTER TABLE SAN_CATEGORIES_RACES
ADD FOREIGN KEY FK_SAN_CATEGORIES_RACES_SAN_RACES (RAC_ID)
REFERENCES SAN_RACES (RAC_ID) ;

ALTER TABLE SAN_CATEGORIES_RACES
ADD FOREIGN KEY FK_SAN_CATEGORIES_RACES_SAN_CATEGORIES (CAT_ID)
REFERENCES SAN_CATEGORIES (CAT_ID) ;

ALTER TABLE SAN_USERS_RACES
ADD FOREIGN KEY FK_SAN_USERS_RACES_SAN_USERS (USE_ID)
REFERENCES SAN_USERS (USE_ID) ;

ALTER TABLE SAN_USERS_RACES
ADD FOREIGN KEY FK_SAN_USERS_RACES_SAN_RACES (RAC_ID)
REFERENCES SAN_RACES (RAC_ID) ;
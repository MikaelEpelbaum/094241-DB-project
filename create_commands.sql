CREATE TABLE Character(
                          cName VARCHAR(50) PRIMARY KEY,
                          role VARCHAR(110),
                          hairColor VARCHAR(40)
);

CREATE TABLE Wizard(
                       cName VARCHAR(50) PRIMARY KEY,
                       wandID INTEGER CHECK(wandID > 0),
                       FOREIGN KEY (cName) REFERENCES Character ON DELETE CASCADE
);

CREATE TABLE Relationship(
                             cName1 VARCHAR(50),
                             cName2 VARCHAR(50),
                             rType CHAR(4)
                                 CHECK (rType = 'Love' or rType = 'Hate'),
                             PRIMARY KEY(cName1, cName2),
                             FOREIGN KEY (cName1) REFERENCES Character(cName) ON DELETE CASCADE,
                             FOREIGN KEY (cName2) REFERENCES Character(cName)
);

CREATE TABLE Spell(
                      magicWord VARCHAR(30) PRIMARY KEY,
                      description VARCHAR(150),
                      difLevel INTEGER,
                      CHECK (difLevel >= 1 AND difLevel <= 5)
);

CREATE TABLE MDate(
    dateVal DATETIME PRIMARY KEY
);

CREATE TABLE Performed(
                          cName VARCHAR(50),
                          magicWord VARCHAR(30) NOT NULL,
                          dateVal DATETIME,
                          PRIMARY KEY (cName, dateVal),
                          FOREIGN KEY (cName) REFERENCES Wizard ON DELETE CASCADE,
                          FOREIGN KEY (dateVal) REFERENCES MDate ON DELETE CASCADE,
                          FOREIGN KEY (magicWord) REFERENCES Spell ON DELETE CASCADE
);

create view longestMagicWord as (
                                select magicWord as val from (
                                                                 select top 1  magicWord, len(magicWord) as len
                                                                 from Spell where difLevel >=4
                                                                 order by len desc
                                                             ) as tbl);

create view notOnlyStudent as (
                              select cName as val from Character
                              where role like '%Student%'
                                and CHARINDEX('|', role) > 0);

create view mostBelovedNonWizard as (
                                    select top 1 sums.name as val from
                                        (select R.cName2 as name, sum(case when R.rtype = 'Hate' then 1 else 0 end) as haters,
                                                sum(case when R.rtype = 'Love' then 1 else 0 end) as lovers
                                         from Relationship R
                                         group by R.cName2) as sums
                                    where haters >= 5 and sums.name not in (select cName from Wizard)
                                    order by lovers desc);
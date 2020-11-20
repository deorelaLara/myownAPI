CREATE DATABASE RickandMorty;

USE RickandMorty;

CREATE TABLE characters(
CharacterId int(20) primary key auto_increment not null,
Name varchar(255) not null,
Type varchar(255) default 'none',
Created varchar(255) default '2017-11-30T11:17:32.733Z',
Photo varchar(255), 
Species varchar(255)
)ENGINE=InnoDb;

INSERT INTO productos (Foto) VALUES ('https://i.ibb.co/f180R8q/1.jpg');

select * from characters;
delete from characters where CharacterId=2;
INSERT INTO characters (Name, Photo, Species) VALUES ('Rick Sanchez', 'https://ibb.co/GTVPDmS', 'Human');
INSERT INTO characters (Name, Photo, Species) VALUES ('Morty Smith', 'https://ibb.co/PD0N8Tv', 'Human');
INSERT INTO characters (Name, Photo, Species) VALUES ('Mr. Meeseeks', 'https://ibb.co/Mc6qCGd', 'Unknown');
INSERT INTO characters (Name, Photo, Species) VALUES ('Mr. Poopybutthole', 'https://ibb.co/J7z2c7n', 'Unknown');
INSERT INTO characters (Name, Photo, Species) VALUES ('Squanchy', 'https://ibb.co/Q9kkktG', 'Squanchies');
INSERT INTO characters (Name, Photo, Species) VALUES ('Evil Morty', 'https://ibb.co/cbLzfzY', 'Humano Mejorado');
INSERT INTO characters (Name, Photo, Species) VALUES ('Snuffles', 'https://ibb.co/8PrqjXY', 'Dog');
INSERT INTO characters (Name, Photo, Species) VALUES ('Summer Smith', 'https://ibb.co/cgB65zq', 'Human');
INSERT INTO characters (Name, Photo, Species) VALUES ('Jerry Smith', 'https://ibb.co/wsRFd3z', 'Human');
INSERT INTO characters (Name, Photo, Species) VALUES ('Abradolf Lincler', 'https://ibb.co/37V8Dbw', 'Human (Composite Clone)');
INSERT INTO characters (Name, Photo, Species) VALUES ('Doofus Rick', 'https://ibb.co/NL6HdZ0', 'Human');
INSERT INTO characters (Name, Photo, Species) VALUES ('Evil Rick', 'https://ibb.co/YT95x3M', 'Humano Mejorado');
INSERT INTO characters (Name, Photo, Species) VALUES ('Ice-T', 'https://ibb.co/XZ60Qb5', 'Alphabetrian');
INSERT INTO characters (Name, Photo, Species) VALUES ('Morty Jr.', 'https://ibb.co/dktb88H', 'Half Huma - Half Gazorpiano');


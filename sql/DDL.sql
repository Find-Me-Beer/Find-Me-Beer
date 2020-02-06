ALTER	DATABASE beer CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS Tag;
DROP TABLE IF EXISTS BeerTag;
DROP TABLE IF EXISTS Favorite;
DROP TABLE IF EXISTS Brewery;
DROP TABLE IF EXISTS Beer;
DROP TABLE IF EXISTS "User";

CREATE TABLE "User" (
  userId Binary(16) NOT NULL,
  userAuthenticationToken Varchar(255) NOT NULL,
  userAvatarUrl Varchar(128),
  userDOB Date NOT NULL,
  userEmail Varchar(128) NOT NULL,
  userFirstName Varchar(32) NOT NULL,
  userHash Varchar(96) NOT NULL,
  userLastName Varchar(32) NOT NULL,
  userUsername Varchar(32) NOT NULL,
  UNIQUE (userEmail),
  UNIQUE (userUsername),
  PRIMARY KEY (userId)
);

CREATE TABLE Beer (
  beerId Binary(16) NOT NULL,
  beerAbv Decimal(8,6) NOT NULL,
  beerBreweryId Binary(16) NOT NULL,
  beerDescription Varchar(1000),
  beerName Varchar(32) NOT NULL,
  beerType Varchar(32) NOT NULL,
  PRIMARY KEY (beerId),
  FOREIGN KEy (beerBreweryId) REFERENCES Brewery(breweryId),
);

CREATE TABLE Brewery (
  breweryId Binary(16) NOT NULL,
  breweryAddress Varchar(512) NOT NULL,
  breweryAvatarUrl Varchar(128) NOT NULL,
  breweryDescription Varchar(1000),
  breweryEmail Varchar(128) NOT NULL,
  breweryName Varchar(32) NOT NULL,
  breweryLat Decimal NOT NULL,
  breweryLong Decimal NOT NULL,
  breweryPhone Varchar(32),
  breweryUrl Varchar(2083) NOT NULL,
  PRIMARY KEY (breweryId)
);

CREATE TABLE Favorite (
  favoriteBeerId Binary(16),
  favoriteUserId Binary(16),
  FOREIGN KEY (favoriteBeerId) REFERENCES Beer(beerId),
  FOREIGN KEY (favoriteUserId) REFERENCES "User"(userId),
);

CREATE TABLE BeerTag (
  beerTagBeerId Binary(16) NOT NULL,
  beerTagTagId Binary(16) NOT NULL,
  FOREIGN KEY (beerTagBeerId) REFERENCES Beer(beerId),
  FOREIGN KEY (beerTagTagId) REFERENCES Tag(tagId),
);

CREATE TABLE Tag (
  tagId Binary(16),
  tagContent Varchar(32),
  PRIMARY KEY (tagId)
);




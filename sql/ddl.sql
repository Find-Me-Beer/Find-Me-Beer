# ALTER	DATABASE beer CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS beerTag;
DROP TABLE IF EXISTS favorite;
DROP TABLE IF EXISTS beer;
DROP TABLE IF EXISTS brewery;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS tag;

CREATE TABLE tag (
  tagId Binary(16),
  tagContent Varchar(32),
  PRIMARY KEY (tagId)
);

CREATE TABLE `user` (
  userId Binary(16) NOT NULL,
  userActivationToken CHAR(32),
  userAvatarUrl Varchar(128),
  userDOB Date NOT NULL,
  userEmail Varchar(128) NOT NULL,
  userFirstName Varchar(32) NOT NULL,
  userHash Varchar(98) NOT NULL,
  userLastName Varchar(32) NOT NULL,
  userUsername Varchar(32) NOT NULL,
  UNIQUE (userEmail),
  UNIQUE (userUsername),
  PRIMARY KEY (userId)
);

CREATE TABLE brewery (
  breweryId Binary(16) NOT NULL,
  breweryAddress Varchar(512) NOT NULL,
  breweryAvatarUrl Varchar(128) NOT NULL,
  breweryDescription Varchar(1000),
  breweryEmail Varchar(128) NOT NULL,
  breweryName Varchar(32) NOT NULL,
  breweryLat Decimal(9,6) NOT NULL,
  breweryLong Decimal(9,6) NOT NULL,
  breweryPhone Varchar(64),
  breweryUrl Varchar(2083) NOT NULL,
  PRIMARY KEY (breweryId)
);

CREATE TABLE beer (
	beerId Binary(16) NOT NULL,
	beerBreweryId Binary(16) NOT NULL,
	beerAbv Decimal(5,3) NOT NULL,
	beerDescription Varchar(1000),
	beerName Varchar(64) NOT NULL,
	beerType Varchar(64) NOT NULL,
	INDEX(beerBreweryId),
	FOREIGN KEY (beerBreweryId) REFERENCES brewery(breweryId),
	PRIMARY KEY (beerId)
);

CREATE TABLE favorite (
  favoriteBeerId Binary(16),
  favoriteUserId Binary(16),
  INDEX(favoriteBeerId),
  INDEX(favoriteUserId),
  FOREIGN KEY (favoriteBeerId) REFERENCES beer(beerId),
  FOREIGN KEY (favoriteUserId) REFERENCES `user`(userId),
  PRIMARY KEY (favoriteBeerId, favoriteUserId)
);

CREATE TABLE beerTag (
  beerTagBeerId Binary(16) NOT NULL,
  beerTagTagId Binary(16) NOT NULL,
  INDEX(beerTagBeerId),
  INDEX(beerTagTagId),
  FOREIGN KEY (beerTagBeerId) REFERENCES beer(beerId),
  FOREIGN KEY (beerTagTagId) REFERENCES tag(tagId),
  PRIMARY KEY (beerTagBeerId, beerTagTagId)
);

-- @author Dylan McDonald <dmcdonald21@cnm.edu>

    -- drop the procedure if already defined
    DROP FUNCTION IF EXISTS haversine;

    -- procedure to calculate the distance between two points
    -- @param FLOAT $userX point of origin, x coordinate
    -- @param FLOAT $userY point of origin, y coordinate
    -- @param FLOAT $breweryX point heading out, x coordinate
    -- @param FLOAT $breweryY point heading out, y coordinate
    -- @return FLOAT distance between the points, in miles
    CREATE FUNCTION haversine(userX FLOAT, userY FLOAT, breweryX FLOAT, breweryY FLOAT) RETURNS FLOAT
    	BEGIN
    		-- first, declare all variables; I don't think you can declare later
    		DECLARE radius FLOAT;
    		DECLARE latitudeAngle1 FLOAT;
    		DECLARE latitudeAngle2 FLOAT;
    		DECLARE latitudePhase FLOAT;
    		DECLARE longitudePhase FLOAT;
    		DECLARE alpha FLOAT;
    		DECLARE corner FLOAT;
    		DECLARE distance FLOAT;

    		-- assign the variables that were declared & use them
    		SET radius = 3958.7613; -- radius of the earth in miles
    		SET latitudeAngle1 = RADIANS(userY);
    		SET latitudeAngle2 = RADIANS(breweryY);
    		SET latitudePhase = RADIANS(breweryY - userY);
    		SET longitudePhase = RADIANS(breweryX - userX);

    		SET alpha = POW(SIN(latitudePhase / 2), 2)
    						+ POW(SIN(longitudePhase / 2), 2)
    						  * COS(latitudeAngle1) * COS(latitudeAngle2);
    		SET corner = 2 * ASIN(SQRT(alpha));
    		SET distance = radius * corner;

    		RETURN distance;
    	END;
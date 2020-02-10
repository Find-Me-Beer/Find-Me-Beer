<?php
namespace FindMeBeer\FindMeBeer;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 *
 *
 * Favorite Beer Class
 *
 * @author Patrick Leyba <pleyba4@cnm.edu>
 * @version 0.0.1
 **/
class Favorite implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for this Favorite; this is the primary key
	 * @var Uuid $FavoriteId
	 **/
	private $FavoriteId;
	/**
	 * id of the User that favorited this beer; this is a foreign key
	 * @var Uuid $FavoriteUserId
	 **/
	private $FavoriteUserId;
	/**
	 *
	 * @var string $FavoriteBeerId
	 **/
	private $FavoriteBeerId;

	/**
	 * constructor for this Favorite
	 *
	 * @param string|Uuid $newFavoriteId id of Beer or null if a new beer
	 * @param string|Uuid $newFavoriteUserId id of the user that favorites this beer
	 * @param string $newFavoriteBeerId string is favorite beer id data
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newFavoriteId, $newFavoriteUserId, $newFavoriteBeerId)
		try {
			$this->setFavoriteId($newFavoriteId);
			$this->setFavoriteUserId($newFavoriteUserId);
			$this->setFavoriteBeerId($newFavoriteBeerId);
		}
			//determine what exception type was thrown
		catch(\Exception $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/** #1
	 * accessor method for favorite id
	 *
	 * @return Uuid value of favorite id
	 **/
	public function getFavoriteId() : Uuid {
		return($this->favoriteId);
	}

	/** #1
	 * mutator method for favorite id
	 *
	 * @param Uuid|string $newFavoriteId new value of favorite id
	 * @throws \RangeException if $newFavoriteId is not positive
	 * @throws \TypeError if $newFavoriteId is not a uuid or string
	 **/
	public function setFavoriteId($newFavoriteId) : void {
		try {
			$uuid = self::validateUuid($newFavoriteId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the beer id
		$this->favoriteId = $uuid;
	}

	/** #2
	 * accessor method for favorite user id
	 *
	 * @return string
	 **/
	public function getFavoriteBeerId(): ?string {
		return($this->FavoriteUserId);
	}

	/** #2
	 * mutator method for favorite user id
	 *
	 * @param string | Uuid $newFavoriteUserId new value of favorite user id
	 * @throws \RangeException if $newFavoriteUserId is not positive
	 * @throws \TypeError if $newFavortieUserId is not an integer
	 **/
	public function setFavoriteUserId(int $newFavoriteUserId) : void {
		try {
			$uuid = self::validateUuid($newFavoriteUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new \$exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the user id
		$this->favoriteUserId = $uuid;
	}

	/** #3
	 * accessor method for favorite beer id
	 *
	 * @return string value of favorite beer id
	 **/
	public function getFavoriteBeerId() : string {
		return($this->favoriteBeerId());
	}

	/** #3
	 * mutator method for favorite beer id
	 *
	 * @param string $newFavoriteBeerId new value of favorite beer id
	 * @throws \InvalidArgumentException if $newFavoriteBeerId is not a string or insecure
	 * @throws \RangeException if $newFavoriteBeerId is > 140 characters
	 * @throws \TypeError if $newFavoriteBeerId is not a string
	 **/
	public function setFavoriteBeerId(int $newFavoriteBeerId) : void {
		// verify the tweet content is secure
		$newFavoriteBeerId = trim($newFavoriteBeerId);
		$newFavoriteBeerId = filter_var($newFavoriteBeerId, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newFavoriteBeerId) === true) {
			throw(new \InvalidArgumentException("favorite beer is empty"));
		}

		// verify the tweet content will fit in the database
		if(strlen($newFavoriteBeerId) > 140) {
			throw(new \RangeException("favorite beer id too large"));
		}

		// store the favorite beer id
		$this->favoriteBeerId = $newFavoriteBeerId;
	}

	/**          PDO 1-1 INSERT
	 * inserts favoriteId into mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) {
	//check that the favorite id exists before inserting into SQL
	if($this->favoriteId === null || $this->favoriteId === null) {
		throw (new \PDOException("favorite id not valid"));
	}
	//create query template
	$query = "INSERT INTO favoriteId(favoriteId, ) VALUES (:favoriteId, :favoriteId)";
	$statement = $pdo->prepare($query);

	//bind the member variables to the place holders in the template
	$parameters = ["favoriteId" => $this->favoriteId, "favoriteId" => $this->favoriteId];
	$statement->execute($parameters);
}

	/**			PDO 1-2 DELETION
	 * deletes this favoriteId from mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occure
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) {
	// check that the object exists before deleting it
	if($this->favoriteId === null || $this->favoriteId === null) {
		throw (new \PDOException ("beer or tag not valid"));
	}
	//create a query template
	$query = "DELETE FROM favorite WHERE favoriteId = :favoriteId AND Id = :beerTagTagId";
	$statement = $pdo->prepare($query);

	//bind the member variables to the place holder in the template
	$parameters = ["beerTagBeerId" => $this->beerTagBeerId, "beerTagTagId" => $this->beerTagTagId];
	$statement->execute($parameters);
}

	/**
	 * gets the favoriteId by favoriteUserId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $favoriteId the favoriteId to search for
	 * @return \SplFixedArray of favoriteId found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getFavoriteIdByFavoriteUserId(\PDO $pdo, int $favoriteId) {
	//sanitize the favorite id
	if($favoriteId < 0) {
		throw (new \PDOException("favorite id is not valid"));
	}
	//create query template
	$query = "SELECT , favoriteId, favoriteUserId, favoriteBeerId FROM favorite WHERE favoriteId = :favoriteId";
	$statement = $pdo->prepare($query);

	//bind the favorite id to the place holder in the template
	$parameters = ["favoriteId" => $favoriteId];
	$statement->execute($parameters);

	//build an array of favorite
	$favoriteId = new \SplFixedArray($statement->rowCount());
	$statement->setFetchMode(\PDO::FETCH_ASSOC);
	while(($row = $statement->fetch()) !== false) {
		try {
			$beerTag = new BeerTag($row["favoriteId"], $row["Id"]);
			$beerTags[$beerTags->key()] = $favoriteId;
			$beerTags->next();
		} catch(\Exception $exception) {
			//if the row cant be converted rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
	}
	return ($favoriteId);
}

	/**
	 * gets the beer tag by tag Id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $beerTagTagId tag Id to search for
	 * @return \SplFixedArray of BeerTags found or null if nothing is found
	 * @throws \PDOException when mySQL related errors are found
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getBeerTagByTagId(\PDO $pdo, int $beerTagTagId) {
	// sanitize the tag id
	if($beerTagTagId < 0) {
		throw(new \PDOException ("Tag Id is not positive"));
	}
	//create query template
	$query = "SELECT beerTagBeerId, beerTagTagId FROM beerTag WHERE beerTagTagId = :beerTagTagId";
	$statement = $pdo->prepare($query);

	//bind the member variables to the placeholders in the template
	$parameters = ["beerTagTagId" => $beerTagTagId];
	$statement->execute($parameters);

	//build an array of beer tags
	$beerTags = new \SplFixedArray($statement->rowCount());
	$statement->setFetchMode(\PDO::FETCH_ASSOC);
	while(($row = $statement->fetch()) !== false) {
		try {
			$beerTag = new BeerTag($row["beerTagBeerId"], $row["beerTagTagId"]);
			$beerTags[$beerTags->key()] = $beerTag;
			$beerTags->next();
		} catch(\Exception $exception) {
			//if the row could not be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
	}
	return ($beerTags);
}

	//get beer tag by beer id and tag id
	/**
	 * gets the beer tag by both beer and tag id
	 * @param \PDO $pdo PDO connection object
	 * @param int $beerTagBeerID beer id to search for
	 * @param int $beerTagTagId tag id to search for
	 * @return BeerTag|null beerTag if found, null if not
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError when variables are not of the correct data type
	 **/
	public static function getBeerTagByBeerIdAndTagId(\PDO $pdo, int $beerTagBeerId, int $beerTagTagId) {
	//sanitize the beer id and the tag id before searching
	if($beerTagBeerId < 0) {
		throw (new \PDOException("beer id is not positive"));
	}
	if($beerTagTagId < 0) {
		throw (new \PDOException("tag id is not positive"));
	}

	//create a query template
	$query = "SELECT beerTagBeerId, beerTagTagId FROM beerTag WHERE beerTagBeerId = :beerTagBeerId AND beerTagTagId = :beerTagTagId;";
	$statement = $pdo->prepare($query);

	//bind the variables to the placeholders in the template
	$parameters = ["beerTagBeerId" => $beerTagBeerId, "beerTagTagId" => $beerTagTagId];
	$statement->execute($parameters);

	//grab the beer tag from mySQL
	try {
		$beerTag = null;
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$row = $statement->fetch();
		if($row !== false) {
			$beerTag = new BeerTag($row["beerTagBeerId"], $row["beerTagTagId"]);
		}
	} catch(\Exception $exception) {

		throw(new \PDOException($exception->getMessage(), 0, $exception));
	}
	return ($beerTag);
}



	//jsonSerialize
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
	$fields = get_object_vars($this);
	return ($fields);
}
}



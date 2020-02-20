<?php
namespace FindMeBeer\FindMeBeer;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 *
 *
 * BeerTag Class
 *
 * @author Patrick Leyba <pleyba4@cnm.edu>
 * @version 0.0.1
 **/
class BeerTag implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id of the Profile that sent this Tweet; this is a foreign key
	 * @var Uuid $beerTagBeerId
	 **/
	private $beerTagBeerId;
	/**
	 * actual beer favorite of this beer
	 * @var Uuid $beerTagTagId
	 **/
	private $beerTagTagId;

	/**
	 * constructor for BeerTag
	 *
	 * @param string|Uuid $newbeerTagBeerId id of the Profile that sent this Tweet
	 * @param string $newbeerTagTagId string containing actual tweet data
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newBeerTagBeerId, $newBeerTagTagId) {
		try {
			$this->setBeerTagBeerId($newBeerTagBeerId);
			$this->setBeerTagtagId($newBeerTagTagId);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for beerTagBeerId
	 *
	 * @return string value of beerTagBeerId
	 **/
	public function getBeerTagBeerId() : uuid {
		return($this->beerTagBeerId);
	}

	/**
	 * mutator method for beerTagBeerId
	 *
	 * @param string $newBeerTagBeerId new value of beerTagBeerId
	 * @throws \InvalidArgumentException if $newBeerTagBeerId is not a string or insecure
	 * @throws \RangeException if $newbeerTagBeerId is > 140 characters
	 * @throws \TypeError if $newFavoriteBeerId is not a string
	 **/
	public function setBeerTagBeerId( $newBeerTagBeerId) : void {
		try {
			$uuid = self::validateUuid($newBeerTagBeerId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the beerTagBeerId
		$this->beerTagBeerId = $uuid;
	}

	/**
	 * accessor method for beerTagTagId
	 *
	 * @return string
	 **/
	public function getBeerTagTagId() : string {
		return($this->beerTagTagId);
	}

	/**
	 * mutator method for beerTagTagId
	 *
	 * @param string | Uuid $newBeerTagTagId new value of favoritesUserId
	 * @throws \RangeException if $newFavoritesUserId is not positive
	 * @throws \TypeError if $newFavoritesUserId is not an integer
	 **/
	public function setBeerTagTagId( $newBeerTagTagId) : void {
		try {
			$uuid = self::validateUuid($newBeerTagTagId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the profile id
		$this->beerTagTagId = $uuid;
	}

	/**
	 * inserts BeerTag into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {

		// create query template
		$query = "INSERT INTO beerTag(beerTagBeerId, beerTagTagId) VALUES(:beerTagBeerId, :beerTagTagId)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["beerTagBeerId" => $this->beerTagBeerId->getBytes(), "beerTagTagId" => $this->beerTagTagId->getBytes()];
		$statement->execute($parameters);
	}

	/***********getFooByBar Methods for BeerTag class beerTagBeerId and beerTagTagId************************
	 * gets beerTag by beerTagBeerId (unfinished)
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $beerTagBeerId id to search by
	 * @param  $beerTagTagId
	 * @return \SplFixedArray SplFixedArray of Favorite found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getBeerTagByBeerTagBeerId(\PDO $pdo, $beerTagBeerId, $beerTagTagId) : \SplFixedArray {

		try {
			$beerTagBeerId = self::validateUuid($beerTagBeerId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT beerTagBeerId FROM beerTag WHERE beerTagTagId = :beerTagTagId";
		$statement = $pdo->prepare($query);
		// bind the favoriteUserId to the place holder in the template
		$parameters = ["beerTagTagId" => $beerTagTagId->getBytes()];
		$statement->execute($parameters);
		// build an array of beerTags
		$beerTags = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$favorites = new Favorite($row["beerTagBeerId"], $row["beerTagTagId"]);
				$beerTagss[$beerTags->key()] = $beerTags;
				$favorites->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($beerTags);
	}


	/**
	 * gets beerTag by beerTagTagId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $favoriteUserId profile id to search by
	 * @return \SplFixedArray SplFixedArray of Favorite found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getBeerTagByBeerTagTagId(\PDO $pdo, $beerTagTagId) : \SplFixedArray {

		try {
			$beerTagTagId = self::validateUuid($beerTagTagId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT beerTagTagId FROM beerTag WHERE beerTagTagId = :beerTagTagId";
		$statement = $pdo->prepare($query);
		// bind the favoriteUserId to the place holder in the template
		$parameters = ["beerTagTagId" => $beerTagTagId->getBytes()];
		$statement->execute($parameters);
		// build an array of beerTags
		$beerTags = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$beerTag = new BeerTag($row["beerTagBeerId"], $row["beerTagTagId"]);
				$beerTags[$beerTags->key()] = $beerTag;
				$beerTags->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($beerTags);
	}

	/**
	 * gets the beerTag by beerTagBeerId and beerTagTagId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $beerTagBeerId beerTag id to search for
	 * @param string $beerTagTagId beerTagTagId to search for
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 * @return favorites|null Like found or null if not found
	 **/
	public static function getBeerTagByBeerTagBeerIdAndBeerTagTagId(\PDO $pdo, string $beerTagBeerId, string $beerTagTagId ) : ?BeerTag {
		// sanitize the beerTagBeerId and beerTagTagId before searching
		try {
			$beerTagBeerId = self::validateUuid($beerTagBeerId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		try {
			$beerTagTagId = self::validateUuid($beerTagTagId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT beerTagBeerId, beerTagTagId FROM beerTag WHERE beerTagBeerId = :beertagBeerId AND beerTagTagId = :beerTagTagId";
		$statement = $pdo->prepare($query);

		// bind the beerTagBeerId to the place holder in the template
		$parameters = ["beerTagBeerId" => $beerTagBeerId->getBytes(), "beerTagTagId" => $beerTagTagId->getBytes()];
		$statement->execute($parameters);

		// grab the beerTags from mySQL
		try {
			$beerTags = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$beerTags = new Favorite($row["beerTagBeerId"], $row["beerTagTagId"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($beerTags);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["beerTagBeerId"] = $this->beerTagBeerId->toString();
		$fields["beerTagTagId"] = $this->beerTagTagId->toString();


		return($fields);
	}
}


<?php
namespace FindMeBeer\FindMeBeer;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 *
 *
 * Favorite Class
 *
 * @author Patrick Leyba <pleyba4@cnm.edu>
 * @version 0.0.1
 **/
class Favorite implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id of the Profile that sent this Tweet; this is a foreign key
	 * @var Uuid $favoriteUserId
	 **/
	private $favoriteUserId;
	/**
	 * actual beer favorite of this beer
	 * @var string $favoriteBeerId
	 **/
	private $favoriteBeerId;

	/**
	 * constructor for Favorite
	 *
	 * @param string|Uuid $newFavoriteBeerId id of the Profile that sent this Tweet
	 * @param string $newFavoriteUserId string containing actual tweet data
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newFavoriteBeerId, $newFavoriteUserId) {
		try {
			$this->setFavoriteBeerId($newFavoriteBeerId);
			$this->setFavoriteUserId($newFavoriteUserId);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for favoriteBeerId
	 *
	 * @return string value of favoriteBeerId
	 **/
	public function getFavoriteBeerId() : uuid {
		return($this->favoriteBeerId);
	}

	/**
	 * mutator method for favoriteBeerId
	 *
	 * @param string $newFavoriteBeerId new value of favoriteBeerId
	 * @throws \InvalidArgumentException if $newFavoriteBeerId is not a string or insecure
	 * @throws \RangeException if $newFavoriteBeerId is > 140 characters
	 * @throws \TypeError if $newFavoriteBeerId is not a string
	 **/
	public function setFavoriteBeerId( $newFavoriteBeerId) : void {
		try {
			$uuid = self::validateUuid($newFavoriteBeerId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the beerId
		$this->favoriteBeerId = $uuid;
	}

	/**
	 * accessor method for favoritesUserId
	 *
	 * @return Uuid value of favoritesUserId
	 **/
	public function getFavoriteUserId() : Uuid{
		return($this->favoriteUserId);
	}

	/**
	 * mutator method for favoriteUserId
	 *
	 * @param string | Uuid $newFavoriteUserId new value of favoritesUserId
	 * @throws \RangeException if $newFavoritesUserId is not positive
	 * @throws \TypeError if $newFavoritesUserId is not an integer
	 **/
	public function setFavoriteUserId( $newFavoriteUserId) : void {
		try {
			$uuid = self::validateUuid($newFavoriteUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the profile id
		$this->favoriteUserId = $uuid;
	}

	/**
	 * inserts Favorite into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {

		// create query template
		$query = "INSERT INTO favorite(favoriteUserId, favoriteBeerId) VALUES(:favoriteUserId, :favoriteBeerId)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["favoriteBeerId" => $this->favoriteBeerId->getBytes(), "favoriteUserId" => $this->favoriteUserId->getBytes()];
		$statement->execute($parameters);
	}


	/**
	 * deletes Favorite from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {

		// create query template
		$query = "DELETE FROM favorite WHERE favoriteBeerId = :favoriteBeerId AND favoriteUserId = :favoriteUserId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["favoriteBeerId" => $this->favoriteBeerId->getBytes(), "favoriteUserId" => $this->favoriteUserId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * gets the Favorites by FavoriteBeerId and favoriteUserId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $favoriteBeerId beer id to search for
	 * @param string $favoriteUserId user id to search for
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 * @return favorites|null Like found or null if not found
	 **/
	public static function getFavoriteByFavoriteBeerIdAndFavoriteUserId(\PDO $pdo, string $favoriteBeerId, string $favoriteUserId ) : ?Favorites {
		// sanitize the favoriteBeerId and favoriteUserId before searching
		try {
			$favoriteBeerId = self::validateUuid($favoriteBeerId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		try {
			$favoriteUserId = self::validateUuid($favoriteUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT favoriteBeerId, favoriteUserId FROM favorite WHERE favoriteBeerId = :favoriteBeerId AND favoriteUserId = :favoriteUserId";
		$statement = $pdo->prepare($query);

		// bind the favoriteBeerId to the place holder in the template
		$parameters = ["favoriteBeerId" => $favoriteBeerId->getBytes(), "favoriteUserId" => $favoriteUserId->getBytes()];
		$statement->execute($parameters);

		// grab the favorite from mySQL
		try {
			$favorites = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$favorite = new Favorite($row["favoritesBeerId"], $row["favoritesUserId"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($favorites);
	}

	/**
	 * gets FavoriteUserId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $favoriteUserId profile id to search by
	 * @return \SplFixedArray SplFixedArray of Favorite found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getFavoriteByFavoriteUserId(\PDO $pdo, $favoriteUserId) : \SplFixedArray {

		try {
			$favoriteUserId = self::validateUuid($favoriteUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT favoriteBeerId, favoriteUserId FROM favorite WHERE favoriteUserId = :favoriteUserId";
		$statement = $pdo->prepare($query);
		// bind the favoriteUserId to the place holder in the template
		$parameters = ["favoriteUserId" => $favoriteUserId->getBytes()];
		$statement->execute($parameters);
		// build an array of favorite
		$favorites = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$favorites = new Favorite($row["favoriteBeerId"], $row["favoriteUserId"]);
				$favorites[$favorites->key()] = $favorites;
				$favorites->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($favorites);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["favoriteBeerId"] = $this->favoriteBeerId->toString();
		$fields["favoriteUserId"] = $this->favoriteUserId->toString();


		return($fields);
	}
}


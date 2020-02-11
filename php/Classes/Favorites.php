<?php
namespace FindMeBeer\FindMeBeer;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 *
 *
 * Favorites Class
 *
 * @author Patrick Leyba <pleyba4@cnm.edu>
 * @version 0.0.1
 **/
class Favorites implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;
	/**
	 * id for Favorites; this is the primary key
	 * @var Uuid $favoritesId
	 **/
	private $favoritesId;
	/**
	 * id of the Profile that sent this Tweet; this is a foreign key
	 * @var Uuid $favoritesUserId
	 **/
	private $favoritesUserId;
	/**
	 * actual beer favorite of this beer
	 * @var string $favoritesBeerId
	 **/
	private $favoritesBeerId;

	/**
	 * constructor for Favorites
	 *
	 * @param string|Uuid $newFavoritesId id of this Tweet or null if a new Tweet
	 * @param string|Uuid $newFavoritesUserId id of the Profile that sent this Tweet
	 * @param string $newFavoritesBeerId string containing actual tweet data
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newFavoritesId, $newFavoritesUserId, $newFavoritesBeerId) {
		try {
			$this->setFavoritesId($newFavoritesId);
			$this->setFavoritesUserId($newFavoritesUserId);
			$this->setFavoritesBeerId($newFavoritesBeerId);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for favoritesId
	 *
	 * @return Uuid value of favoritesId
	 **/
	public function getFavoritesId() : Uuid {
		return($this->favoritesId);
	}

	/**
	 * mutator method for favoritesId
	 *
	 * @param Uuid|string $newFavoritesId new value of favoritesId
	 * @throws \RangeException if $newFavoritesId is not positive
	 * @throws \TypeError if $newFavoritesId is not a uuid or string
	 **/
	public function setFavoritesId( $newFavoritesId) : void {
		try {
			$uuid = self::validateUuid($newFavoritesId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the favoritesId
		$this->favoritesId = $uuid;
	}

	/**
	 * accessor method for favoritesUserId
	 *
	 * @return Uuid value of favoritesUserId
	 **/
	public function getFavoritesUserId() : Uuid{
		return($this->favoritesUserId);
	}

	/**
	 * mutator method for favoritesUserId
	 *
	 * @param string | Uuid $newFavoritesUserId new value of favoritesUserId
	 * @throws \RangeException if $newFavoritesUserId is not positive
	 * @throws \TypeError if $newFavoritesUserId is not an integer
	 **/
	public function setFavoritesUserId( $newFavoritesUserId) : void {
		try {
			$uuid = self::validateUuid($newFavoritesUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the profile id
		$this->favoritesUserId = $uuid;
	}

	/**
	 * accessor method for favoritesBeerId
	 *
	 * @return string value of favoritesBeerId
	 **/
	public function getFavoritesBeerId() : string {
		return($this->favoritesBeerId);
	}

	/**
	 * mutator method for favoritesBeerId
	 *
	 * @param string $newFavoritesBeerId new value of tweet content
	 * @throws \InvalidArgumentException if $newFavoritesBeerId is not a string or insecure
	 * @throws \RangeException if $newFavoritesBeerId is > 140 characters
	 * @throws \TypeError if $newFavoritesBeerId is not a string
	 **/
	public function setFavoritesBeerId(string $newFavoritesBeerId) : void {
		// verify the tweet content is secure
		$newFavoritesBeerId = trim($newFavoritesBeerId);
		$newFavoritesBeerId = filter_var($newFavoritesBeerId, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newFavoritesBeerId) === true) {
			throw(new \InvalidArgumentException("tweet content is empty or insecure"));
		}

		// verify the tweet content will fit in the database
		if(strlen($newFavoritesBeerId) > 140) {
			throw(new \RangeException("tweet content too large"));
		}

		// store the tweet content
		$this->favoritesBeerId = $newFavoritesBeerId;
	}

	/**
	 * inserts Favorites into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {

		// create query template
		$query = "INSERT INTO favorites(favoritesId,favoritesUserId, favoritesBeerId) VALUES(:favoritesId, :favoritesUserId, :favoritesBeerId)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->favoritesDate->format("Y-m-d H:i:s.u");
		$parameters = ["tweetId" => $this->tweetId->getBytes(), "tweetProfileId" => $this->favoritesUserId->getBytes(), "tweetContent" => $this->favoritesBeerId, "favoritesBeerId" => $formattedDate];
		$statement->execute($parameters);
	}


	/**
	 * deletes Favorites from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {

		// create query template
		$query = "DELETE FROM tweet WHERE tweetId = :tweetId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["tweetId" => $this->tweetId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * updates this Favorites in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {

		// create query template
		$query = "UPDATE tweet SET tweetProfileId = :tweetProfileId, tweetContent = :tweetContent, tweetDate = :tweetDate WHERE tweetId = :tweetId";
		$statement = $pdo->prepare($query);


		$formattedDate = $this->tweetDate->format("Y-m-d H:i:s.u");
		$parameters = ["tweetId" => $this->tweetId->getBytes(),"tweetProfileId" => $this->tweetProfileId->getBytes(), "tweetContent" => $this->tweetContent, "tweetDate" => $formattedDate];
		$statement->execute($parameters);
	}

	/**
	 * gets the Favorites by FavoritesId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $favoritesId tweet id to search for
	 * @return Tweet|null Tweet found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getFavoritesByFavoritesId(\PDO $pdo, $favoritesId) : ?Favorites {
		// sanitize the favoritesId before searching
		try {
			$tweetId = self::validateUuid($favoritesId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT favoritesId, favoritesUserId, favoritesBeerId FROM favorites WHERE favoritesId = :favoritesId";
		$statement = $pdo->prepare($query);

		// bind the favoritesId to the place holder in the template
		$parameters = ["favoritesId" => $favoritesId->getBytes()];
		$statement->execute($parameters);

		// grab the favorite from mySQL
		try {
			$favoritesId = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$tweet = new Favorites($row["favoritesId"], $row["favoritesUserId"], $row["favoritesBeerId"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($favoritesId);
	}

	/**
	 * gets Favorites by profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $tweetProfileId profile id to search by
	 * @return \SplFixedArray SplFixedArray of Tweets found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getFavoritesByFavoritesUserId(\PDO $pdo, $favoritesUserId) : \SplFixedArray {

		try {
			$favoritesUserId = self::validateUuid($favoritesUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT tweetId, tweetProfileId, tweetContent, tweetDate FROM tweet WHERE tweetProfileId = :tweetProfileId";
		$statement = $pdo->prepare($query);
		// bind the tweet profile id to the place holder in the template
		$parameters = ["favoritesUserId" => $favoritesUserId->getBytes()];
		$statement->execute($parameters);
		// build an array of tweets
		$tweets = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$tweet = new Tweet($row["favoritesId"], $row["favoritesUserId"], $row["favoritesBeerId"]);
				$tweets[$tweets->key()] = $tweet;
				$tweets->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($tweets);
	}

	/**
	 * gets Favorites by BeerId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $favoritesBeerId beerId to search for
	 * @return \SplFixedArray SplFixedArray of Favorites found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getFavoritesByBeerId(\PDO $pdo, string $favoritesBeerId) : \SplFixedArray {
		// sanitize the description before searching
		$favoritesBeerId = trim($favoritesBeerId);
		$favoritesBeerId = filter_var($favoritesBeerId, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($favoritesBeerId) === true) {
			throw(new \PDOException("favorite beer is invalid"));
		}

		// escape any mySQL wild cards
		$favoritesBeerId = str_replace("_", "\\_", str_replace("%", "\\%", $favoritesBeerId));

		// create query template
		$query = "SELECT favoritesId, favoritesUserId, favoritesBeerId FROM favorites WHERE favoritesBeerId LIKE :favoritesBeerId";
		$statement = $pdo->prepare($query);

		// bind the tweet content to the place holder in the template
		$favoritesBeerId = "%$favoritesBeerId%";
		$parameters = ["favoritesBeerId" => $favoritesBeerId];
		$statement->execute($parameters);

		// build an array of tweets
		$tweets = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$tweet = new Tweet($row["tweetId"], $row["tweetProfileId"], $row["tweetContent"], $row["tweetDate"]);
				$tweets[$tweets->key()] = $tweet;
				$tweets->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($favoritesBeerId);
	}

	/**
	 * gets all Favorites
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Tweets found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllFavorites(\PDO $pdo) : \SPLFixedArray {
		// create query template
		$query = "SELECT favoritesId, favoritesUserId, favoritesBeerId FROM favorites";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of favorites
		$favorites = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$favorites = new Favorites($row["favoritesId"], $row["favoritesUserId"], $row["favoritesBeerId"]);
				$favorites[$favorites->key()] = $favorites;
				$favorites->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($favorites);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["favoritesId"] = $this->favoritesUserId->toString();
		$fields["favoritesUserId"] = $this->favoritesUserId->toString();

		//format the date so that the front end can consume it
		$fields["tweetDate"] = round(floatval($this->tweetDate->format("U.u")) * 1000);
		return($fields);
	}
}

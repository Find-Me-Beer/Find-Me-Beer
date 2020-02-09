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



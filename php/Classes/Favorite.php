<?php
namespace FindMeBeer\FindMeBeer;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * User favorites a beer Class
 *
 * Favorite Beer Class
 *
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 * @version 3.0.0
 **/
class Favorite implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;
	/**
	 * id for this Tweet; this is the primary key
	 * @var Uuid $FavoriteId
	 **/
	private $FavoriteId;
	/**
	 * id of the Profile that favorited this beer; this is a foreign key
	 * @var Uuid $FavoriteUserId
	 **/
	private $FavoriteUserId;
	/**
	 * actual textual content of this beer
	 * @var string $FavoriteBeerId
	 **/
	private $FavoriteBeerId;
	/**
	 * date and time this beer was favorited, in a PHP DateTime object
	 * @var \DateTime $newDate
	 **/
	private $newDate;

	/**
	 * constructor for this Tweet
	 *
	 * @param string|Uuid $newTweetId id of Beer or null if a new beer
	 * @param string|Uuid $newFavoriteBeerId id of the Profile that sent this Tweet
	 * @param string $newTweetContent string containing actual tweet data
	 * @param \DateTime|string|null $newTweetDate date and time Tweet was sent or null if set to current date and time
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newFavoriteId, $newFavoriteId, string $newTweetContent, $newTweetDate = null) {
		try {
			$this->setFavoriteId($newFavoriteId);
			$this->setFavoriteUserId($newFavoriteUserId);
			$this->setFavoriteBeerId($newTweetContent);
			$this->setDate($newDate);
		}
			//determine what exception type was thrown
		catch(\Exception $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for beer id
	 *
	 * @return Uuid value of beer id
	 **/
	public function getFavoriteId() : Uuid {
		return($this->FavoriteId);
	}

	/**
	 * mutator method for beer id
	 *
	 * @param Uuid|string $newFavoriteId new value of tweet id
	 * @throws \RangeException if $newTweetId is not positive
	 * @throws \TypeError if $newTweetId is not a uuid or string
	 **/
	public function setFavoriteId( $newFavoriteId) : void {
		try {
			$uuid = self::validateUuid($newFavoriteId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the tweet id
		$this->tweetId = $uuid;
	}

	/**
	 * accessor method for tweet profile id
	 *
	 * @return Uuid value of tweet profile id
	 **/
	public function getTweetProfileId() : Uuid{
		return($this->tweetProfileId);
	}

	/**
	 * mutator method for tweet profile id
	 *
	 * @param string | Uuid $newTweetProfileId new value of tweet profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newTweetProfileId is not an integer
	 **/
	public function setTweetProfileId( $newTweetProfileId) : void {
		try {
			$uuid = self::validateUuid($newTweetProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the profile id
		$this->tweetProfileId = $uuid;
	}

	/**
	 * accessor method for tweet content
	 *
	 * @return string value of tweet content
	 **/
	public function getTweetContent() : string {
		return($this->tweetContent);
	}

	/**
	 * mutator method for tweet content
	 *
	 * @param string $newTweetContent new value of tweet content
	 * @throws \InvalidArgumentException if $newTweetContent is not a string or insecure
	 * @throws \RangeException if $newTweetContent is > 140 characters
	 * @throws \TypeError if $newTweetContent is not a string
	 **/
	public function setTweetContent(string $newTweetContent) : void {
		// verify the tweet content is secure
		$newTweetContent = trim($newTweetContent);
		$newTweetContent = filter_var($newTweetContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newTweetContent) === true) {
			throw(new \InvalidArgumentException("tweet content is empty or insecure"));
		}

		// verify the tweet content will fit in the database
		if(strlen($newTweetContent) > 140) {
			throw(new \RangeException("tweet content too large"));
		}

		// store the tweet content
		$this->tweetContent = $newTweetContent;
	}

	/**
	 * accessor method for tweet date
	 *
	 * @return \DateTime value of tweet date
	 **/
	public function getNewDate() : \DateTime {
		return($this->newDate);
	}

	/**
	 * mutator method for tweet date
	 *
	 * @param \DateTime|string|null $newDate tweet date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newTweetDate is not a valid object or string
	 * @throws \RangeException if $newTweetDate is a date that does not exist
	 **/
	public function setTweetDate($newTweetDate = null) : void {
		// base case: if the date is null, use the current date and time
		if($newTweetDate === null) {
			$this->tweetDate = new \DateTime();
			return;
		}

		// store the like date using the ValidateDate trait
		try {
			$newTweetDate = self::validateDateTime($newTweetDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->tweetDate = $newTweetDate;
	}

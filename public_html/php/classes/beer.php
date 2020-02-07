<?php
namespace ;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Beer class for Find Me Beer Web App
 *
 * This class will hold all the necessary state variables and methods for Beer objects
 *
 * @author Reece Nunn <
 * @version 3.0.0
 **/
class Beer implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;
	/**
	 * id for this beer; this is the primary key
	 * @var Uuid $beerId
	 */
	private $beerId;
	/**
	 * abv for this beer
	 * @var Decimal $beerAbv
	 */
	private $beerAbv;
	/**
	 * brewery id for this beer; this is the foreign key
	 * @var Uuid $beerBreweryId
	 */
	private $beerBreweryId;
	/**
	 * description for the beer
	 * @var String $beerDescription
	 */
	private $beerDescription;
	/**
	 * name of the beer
	 * @var String $beerName
	 */
	private $beerName;
	/**
	 * type of the beer
	 * @var String $beerType
	 */
	private $beerType;

	/**
	 * constructor method for this beer
	 *
	 * @param String|Uuid $newBeerId id of this beer
	 * @param String|Decimal $newBeerAbv abv of this beer
	 * @param String|Uuid $newBeerBreweryId brewery id for this beer
	 * @param String $newBeerDescription description of the beer
	 * @param String $newBeerName name of the beer
	 * @param String $newBeerType type of the beer
	 */
	public function __construct($newBeerId, $newBeerAbv, $newBeerBreweryId, $newBeerDescription, $newBeerName, $newBeerType) {
		try {
			$this->setBeerId($newBeerId);
			$this->setBeerAbv($newBeerAbv);
			$this->setBeerBreweryId($newBeerBreweryId);
			$this->setBeerDescription($newBeerDescription);
			$this->setBeerName($newBeerName);
			$this->setBeerType($newBeerType);
		}  //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * getter method for beer id
	 *
	 * @return Uuid value of beer id
	 */
	public function getBeerId(): void {
		return ($this->beerId);
	}

	/**
	 * setter method for beer id
	 *
	 * @param Uuid|String $newBeerId new value of beer id
	 * @throws \RangeException if $newTweetId is not positive
	 * @throws \TypeError if $newTweetId is not a uuid or string
	 */
	public function setBeerId($newBeerId): void {
		$newBeerId = trim($newBeerId);
		$newBeerId = filter_var($newBeerId, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		try {
			$uuid = self::validateUuid($newBeerId);
		} catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->beerId = $uuid;
	}

}
<?php
namespace FindMeBeer\FindMeBeer;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Cassandra\Decimal;
use MongoDB\BSON\Binary;
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
	 * @param String|Uuid $newBeerBreweryId
	 * @param String $newBeerDescription description of this beer
	 * @param String $newBeerName name of this beer
	 * @param String $newBeerType type of this beer
	 */
	public function __construct($newBeerId, $newBeerAbv, $newBeerBreweryId, $newBeerDescription, $newBeerName, $newBeerType) {
		try {
			$this->setBeerId = $newBeerId;
			$this->setBeerAbv = $newBeerAbv;
			$this->setBeerBreweryId = $newBeerBreweryId;
			$this->setBeerDescription = $newBeerDescription;
			$this->setBeerName = $newBeerName;
			$this->setBeerType = $newBeerType;
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for beer id
	 * @return Uuid value of beer id
	 */
	public function getBeerId(): Uuid {
		return ($this->beerId);
	}

	/**
	 * mutator method for beer id
	 *
	 * @param String | Uuid $newBeerId new id of this beer
	 * @throws \RangeException if $newBeerId is not positive
	 * @throws \TypeError if $newBeerId is not an integer
	 */
	public function setBeerId($newBeerId): void {
		try {
			$uuid = self::validateUuid($newBeerId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		$this->beerId = $uuid;
	}

	/**
	 * accessor method for beer abv
	 * @return Decimal abv for this beer
	 */
	public function getBeerAbv(): Decimal {
		return ($this->beerAbv);
	}

	/**
	 * mutator method for beer abv
	 *
	 * @param Decimal $newBeerAbv new abv for beer
	 * @throws \RangeException if abv is out of appropriate range
	 */
	public function setBeerAbv(Decimal $newBeerAbv): void {
		//Verify the abv is between 0 - 100% ABV
		if($newBeerAbv < 0 || $newBeerAbv > 100) {
			throw (new\RangeException("beer abv is out of appropriate range"));
		}

		//store new beer abv
		$this->beerAbv = $newBeerAbv;

	}

	/**
	 * accessor method for beer brewery id
	 * @return Uuid value of beer brewery id
	 */
	public function getBeerBreweryId(): Uuid {
		return ($this->beerBreweryId);
	}
	/**
	 * mutator method for beer brewery id
	 *
	 * @param Uuid|String $newBeerBreweryId new beer brewery id
	 * @throws \RangeException if $newBreweryId is not positive
	 * @throws \TypeError if $newBreweryId is not a uuid or string
	 */
	public function setBeerBreweryId($newBeerBreweryId): void {
		//Verify $newBeerBreweryId is a valid Uuid
		try {
			$uuid = self::validateUuid($newBeerBreweryId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		//Store new beer brewery id
		$this->beerBreweryId = $uuid;
	}


}

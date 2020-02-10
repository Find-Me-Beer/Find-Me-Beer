<?php
namespace FindMeBeer\FindMeBeer;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use phpDocumentor\Reflection\Types\Void_;
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

	/**
	 * accessor method for beer description
	 * @return String value of beer description
	 */
	public function getBeerDescription(): String {
		return ($this->beerDescription);
	}
	/**
	 * mutator method for beer description
	 *
	 * @param String $newBeerDescription new beer description
	 * @throws \RangeException if $newBreweryDescription is not under 1000 characters
	 * @throws \TypeError if $newBreweryDescription is not a string
	 */
	public function setBeerDescription($newBeerDescription): void {
		//Sanitize and verify $newBeerDescription is secure
		$newBeerDescription = trim($newBeerDescription);
		$newBeerDescription = filter_var($newBeerDescription, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if($newBeerDescription === null) {
			$this->beerDescription = null;
		}

		//verify $newBeerDescription will fit into the database
		if(strlen($newBeerDescription) > 1000) {
			throw(new\RangeException("Beer description is too long"));
		}

		//Store new beer description
		$this->beerDescription = $newBeerDescription;
	}

	/**
	 * accessor method for beer name
	 * @return String value of beer name
	 */
	public function getBeerName() : String {
		return($this->beerName);
	}
	/**
	 * mutator method for beer name
	 *
	 * @param String $newBeerName new name of beer
	 * @throws \InvalidArgumentException if $newBeerName is not a string or insecure
	 * @throws \RangeException if $newBeerName is > 64 characters
	 * @throws \TypeError if $newBeerName is not a string
	 */
		public function setBeerName(String $newBeerName) : void {
			//Sanitize and verify $newBeerName is secure
			$newBeerName = trim($newBeerName);
			$newBeerName = filter_var($newBeerName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($newBeerName) === true) {
				throw(new \InvalidArgumentException("Beer name is empty or insecure"));
			}

			//Verify beer name will fit in the database
			if(strlen($newBeerName) > 64) {
				throw (new\RangeException("beer name is too long"));
			}

			//store new beer name
			$this->beerName = $newBeerName;
		}

		/**
		 * accessor method for beer type
		 * @return String value of beer type
		 */
		public function getBeerType() : String {
			return($this->beerName);
		}
		/**
		 * mutator method for beer type
		 *
		 * @param String $newBeerType new type of the beer
		 * @throws \InvalidArgumentException if $newBeerType is not a string or insecure
		 * @throws \RangeException if $newBeerName is > 64 characters
		 * @throws \TypeError if $newBeerType is not a string
		 */
		public function setBeerType(String $newBeerType) : void {
			//Sanitize and verify $newBeerType is secure
			$newBeerType = trim($newBeerType);
			$newBeerType = filter_var($newBeerType, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($newBeerType) === true) {
				throw(new \InvalidArgumentException("Beer type is empty or insecure"));
			}

			//verify $newBeerType will fit into the database
			if(strlen($newBeerType) > 64) {
				throw (new\RangeException("Beer type is too long"));
			}

			//store new beer type
			$this->beerType = $newBeerType;
		}

		/**
		 * inserts this Beer into mySQL
		 *
		 * @param \PDO $pdo PDO Connection Object
		 * @throws \PDOException when mySQL related error occurs
		 * @throws \TypeError if $pdo is not a PDO Connection Object
		 */
		public function insert(\PDO $pdo) : void {

			//Create query
			$query = "INSERT INTO beer(beerId, beerAbv, beerBreweryId, beerDescription,  beerName, beerType) VALUES(:beerId, :beerAbv, :beerBreweryId, :beerDescription, :beerName, :beerType)";
			$statement = $pdo->prepare($query);

			//bind variables to placeholders
			$parameters = ["beerId" => $this->beerId->getBytes(), "beerAbv" => $this->beerAbv->getBytes(), "beerBreweryId" => $this->beerBreweryId->getBytes(), "beerDescription" => $this->beerDescription->getBytes(), "beerName" => $this->beerName->getBytes(), "beerType" => $this->beerType->getBytes()];
			$statement->execute($parameters);
		}

		/**
		 * deletes this beer from mySQL
		 *
		 * @param \PDO $pdo PDO Connection Object
		 * @throws \PDOException when mySQL error occurs
		 * @throws /\TypeError if $pdo is not a PDO Connection Object
		 */
		public function delete(\PDO $pdo) :void {
			//Create Query
			$query = "DELETE FROM beer WHERE beerId = :beerId";
			$statement = $pdo->prepare($query);

			//Bind member variables to placeholder
			$parameters = ["beerId" => $this->beerId->getBytes()];
			$statement->execute($parameters);
		}

		/**
		 * updates beer in mySQL
		 * @throws \PDOException when mySQL error occurs
		 * @throws \TypeError if $pdo is not a PDO Connection Object
		 */
		public function update(\PDO $pdo) :void {
			//Query
			$query = "UPDATE beer WHERE beerId = :beerId, beerAbv = :beerAbv, beerBreweryId = :beerBreweryId, beerDescription = :beerDescription, beerName = :beerName, beerType = :beerType";
			$statement = $pdo->prepare($query);

			//Bind member variables to placeholders
			$parameters = ["beerId" => $this->beerId->getBytes(), "beerAbv" => $this->beerAbv->getBytes(), "beerBreweryId" => $this->beerBreweryId->getBytes(), "beerDescription" => $this->beerDescription->getBytes(), "beerName" => $this->beerName->getBytes(), "beerType" => $this->beerType->getBytes()];
			$statement->execute($parameters);
		}

		/**
		 * gets all beer from beer table
		 *
		 * @param \PDO $pdo PDO connection object
		 * @return \SplFixedArray SplFixedArray of beer found or null if not found
		 * @throws \PDOException when mySQL related errors occur
		 * @throws \TypeError when variables are not the correct data type
		 */





}

<?php

namespace FindMeBeer\FindMeBeer;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Class  Brewery
 *
 * @Author Celeste Whitaker <cwhitaker4@cnm.edu>
 */

/**
 *
 *
 * breweryId binary(16) PRIMARY KEY
 * breweryAddress Varchar(512)
 * breweryAvatarUrl Varchar(128)
 * breweryDescription Varchar(1000)
 * breweryEmail Varchar(128)
 * breweryName Varchar(32)
 * breweryLat Decimal
 * breweryLong Decimal
 * breweryPhone Varchar(32)
 * breweryUrl Varchar(2083)
 *
 *
 *
 */
class Brewery implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for this brewery; this is the primary key
	 * @var Uuid $breweryId
	 */
	private $breweryId;
	/**
	 *
	 * @var string $breweryAddress
	 *
	 */
	private $breweryAddress;
	/**
	 * @var string $breweryAvatarUrl
	 */
	private $breweryAvatarUrl;
	/**
	 * @var string $breweryDescription
	 */
	private $breweryDescription;
	/**
	 * @var string $breweryEmail
	 */
	private $breweryEmail;
	/**
	 * @var string $breweryName
	 */
	private $breweryName;
	/**
	 * @var float $breweryLat
	 */
	private $breweryLat;
	/**
	 * @var float $breweryLong
	 */
	private $breweryLong;
	/**
	 * @var string $breweryPhone
	 */
	private $breweryPhone;
	/**
	 * @var string $breweryUrl
	 */
	private $breweryUrl;

	/**
	 * Brewery constructor.
	 *
	 * @param $newBreweryId string|Uuid
	 * @param string $newBreweryAddress
	 * @param string $newBreweryAvatarUrl
	 * @param string|null $newBreweryDescription
	 * @param $newBreweryEmail
	 * @param $newBreweryLat
	 * @param $newBreweryLong
	 * @param $newBreweryName
	 * @param $newBreweryPhone
	 * @param $newBreweryUrl
	 */

	public function __construct($newBreweryId, string $newBreweryAddress, string $newBreweryAvatarUrl, ?string $newBreweryDescription, string $newBreweryEmail, float $newBreweryLat, float $newBreweryLong, string $newBreweryPhone, $newBreweryUrl) {
		try {
			$this->setbreweryId($newBreweryId);
			$this->setbreweryAddress($newBreweryAddress);
			$this->setbreweryAvatarUrl($newBreweryAvatarUrl);
			$this->setbreweryDescription($newBreweryDescription);
			$this->setbreweryEmail($newBreweryEmail);
			$this->setbreweryName($newBreweryName);
			$this->setbreweryLat($newBreweryLat);
			$this->setbreweryLong($newBreweryLong);
			$this->setbreweryPhone($newBreweryPhone);
			$this->setbreweryUrl($newBreweryUrl);

		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for brewery id
	 * @return Uuid value of brewery Id
	 */
	public function getBreweryId(): Uuid {
		return ($this->breweryId);
	}

	/**
	 * mutator of breweryId
	 * @param Uuid $newBreweryId
	 * @throws \RangeException if $newBreweryId is not positive
	 * @throws \TypeError if $newBreweryId is not a uuid or string
	 */

	public function setBreweryId($newBreweryId): void {
		try {
			$uuid = self::validateUuid($newBreweryId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store breweryId
		$this->breweryId = $uuid;

	}

	/**
	 * accessor for brewery address
	 * @return string brewery address
	 */
	public function getbreweryAddress(): string {
		return ($this->breweryAddress);
	}

	/**
	 * mutator for brewery address
	 * @param string $newBreweryAddress
	 * @throws \InvalidArgumentException if $newBreweryAddress if address is too long
	 */
	public function setbreweryAddress(string $newBreweryAddress): void {
		// if address is empty throw them out early
		if(empty($newBreweryAddress) === true) {
			throw(new \InvalidArgumentException("Brewery address is not valid"));
		}

		$newBreweryAddress = trim($newBreweryAddress);
		$newBreweryAddress = filter_var($newBreweryAddress, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// verify the brewery Address will fit in the database
		if(strlen($newBreweryAddress) > 512) {
			throw(new \RangeException("Brewery address is over 512 characters"));
		}

		// store the brewery Address
		$this->breweryAddress = $newBreweryAddress;
	}

	/**
	 * accessor method for breweryAvatarUrl
	 * @return String value for breweryAvatarUrl
	 *
	 */
	public function getbreweryAvatarUrl(): string {
		return ($this->breweryAvatarUrl);
	}

	/**
	 * mutator method for breweryAvatarUrl
	 *
	 * @param $newBreweryAvatarUrl
	 *
	 */
	public function setbreweryAvatarUrl($newBreweryAvatarUrl): void {

		// this mutator needs to be finished - trimmed and santized like the others. check length too.
		$this->breweryAvatarUrl = $newBreweryAvatarUrl;
	}

	/**
	 * accessor method for breweryDescription
	 * @return String value of breweryAvatarUrl
	 **/
	public function setbreweryDescription(string $newBreweryDescription): void {

		if($newBreweryDescription === null) {
			$this->newbreweryDescription = null;
			return;
		}

		// fix this block - see trim and filters in other mutators for example
//		$newbreweryDescription = string(trim($newbreweryDescription) {
//		if(empty($newbreweryDescription) === true) {
//			throw(new\RangeException("Brewery description is not valid"));
//		}

		//make sure breweryDescription is 1000 characters or less
		if(strlen($newBreweryDescription) > 1000) {
			throw(new\RangeException("Brewery description is too long"));
		}

		//store the brewery description
		$this->breweryDescription = $newBreweryDescription;

		// is this an orphan?
		throw(new \InvalidArgumentException("Content is empty or insecure"));
	}

	/**
	 * accessor method for brewery email
	 *
	 * @return string
	 */
	public function getBreweryEmail() : string {
		return ($this->breweryEmail);
	}

	public function setBreweryEmail(string $newBreweryEmail): void {

		if(empty($newBreweryEmail) === true) {
			throw(new \InvalidArgumentException("Brewery email is not valid"));
		}

		$newBreweryEmail = trim($newBreweryEmail);
		// we can use php FILTER_SANITIZE_EMAIL
		$newBreweryEmail = filter_var($newBreweryEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// verify the brewery email will fit in the database
		if(strlen($newBreweryEmail) > 128) {
			throw(new \RangeException("Brewery email is too large"));
		}

		// store the brewery email
		$this->breweryEmail = $newBreweryEmail;
	}

	// do dockblocks
	public function getbreweryName(): string {
		return ($this->breweryName);
	}

	/*
	 * mutator method for brewery Name
	 * @param string $newBreweryName
	 * @throws \RangeException if $newBreweryName is > 32 characters
	 * @throws \TypeError if $newBreweryName is not a string
	 */
	public function setbreweryName(string $newBreweryName): void {

		// check for null - if so, throw exception

		//verify new brewery name is secure
		$newBreweryName = trim($newBreweryName);
		$newBreweryName = FILTER_VAR($newBreweryName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		//verify size of string is less than 32 characters
		if(strlen($newBreweryName) > 32) {
			throw(new \RangeException(""));
		}

		// store brewery Name
		$this->breweryName = $newBreweryName;

	}

	/**
	 * accessor for brewery latitude
	 * @return float brewery latitude between -90 and 90
	 **/
	public function getbreweryLat(): float {
		return ($this->breweryLat);
	}

	/**
	 * mutator for brewery latitude
	 * @param float $newBreweryLat new value of the brewery latitude
	 * @throws \RangeException if $newbreweryLat is outside of range
	 **/
	public function setbreweryLat(float $newBreweryLat): void {
		//verify that brewery latitude is valid and secure
		$newBreweryLat = trim($newBreweryLat);
		$newBreweryLat = filter_var($newBreweryLat, FILTER_SANITIZE_NUMBER_FLOAT);

		if(floatval($newBreweryLat) < -90) {
			throw(new \RangeException("Error latitude is incorrect"));
		}

		//verify brewery latitude will fit into database
		if(floatval($newBreweryLat) > 90) {
			throw(new \RangeException("Error latitude is incorrect"));
		}

		//store the latitude data
		$this->breweryLat = $newBreweryLat;
	}

	/**
	 * accessor for brewery longitude
	 * @return float brewery longitude in degrees between -180 and 180
	 **/

	public function getbreweryLong(): float {
		return ($this->breweryLong);

	}

	/**
	 * mutator for brewery longitude
	 * @param float $newBreweryLong new value of the brewery longitude
	 * @throws \RangeException if $newbreweryLong is outside of range
	 **/

	public function setbreweryLong(float $newBreweryLong): void {

//		//verify that brewery longitude is valid and secure
		$newBreweryLong = trim($newBreweryLong);
		$newBreweryLong = filter_var($newBreweryLong, FILTER_SANITIZE_NUMBER_FLOAT);
		if(floatval($newBreweryLong) < -180) {
			throw(new \RangeException("Brewery longitude is incorrect"));

		}

		if(floatval($newBreweryLong) > 180) {
			throw(new \RangeException("Brewery longitude is incorrect"));

		}

		//store the latitude data
		$this->breweryLong = $newBreweryLong;
	}

	/**
	 *  accessor for brewery phone
	 * @return string value for brewery phone
	 */
	public function getbreweryPhone(): string {
		return ($this->breweryPhone);
	}

	/**
	 * mutator method for brewery Phone
	 * @param string $newBreweryPhone
	 * @throws \RangeException if $newBreweryPhone is > 64 characters
	 * @throws \TypeError if $newBreweryPhone is not a string
	 **/

	public function setbreweryPhone(string $newBreweryPhone): void {

		// if phone is null, set to null and return - just like we did for description

		//verify new brewery phone is secure
		$newBreweryPhone = trim($newBreweryPhone);
		$newBreweryPhone = FILTER_VAR($newBreweryPhone, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		//verify size of string is less than 64 characters
		if(strlen($newBreweryPhone) > 64) {
			throw(new \RangeException("brewery phone is too long"));
		}

		// store brewery Phone
		$this->breweryPhone = $newBreweryPhone;
	}

	public function getbreweryUrl(): string {
		return ($this->breweryUrl);
	}

	/**
	 * mutator method for breweryUrl
	 * @param string $newBreweryUrl
	 * @throws \RangeException if $newBreweryUrl is > 2083 characters
	 * @throws \TypeError if $newBreweryUrl is not a string
	 **/
	public function setbreweryUrl(string $newBreweryUrl): void {
		//verify new brewery url is secure
		$newBreweryUrl = trim($newBreweryUrl);
		// we can use php FILTER_SANITIZE_URL
		$newBreweryUrl = FILTER_VAR($newBreweryUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		//verify size of string is less than 2083 characters
		if(strlen($newBreweryUrl) > 2083) {
			throw(new \RangeException("Brewery URL is too long"));
		}
		// store breweryUrl
		$this->breweryUrl = $newBreweryUrl;
	}


	// do dockblocks
	public function insert(\PDO $pdo): void {

		// create query template
		$query = "INSERT INTO brewery(breweryId, breweryAddress, breweryAvatarUrl, breweryDescription, breweryEmail, breweryName, breweryLat, breweryLong, breweryPhone, breweryUrl) VALUES(:breweryId, :breweryAddress, :breweryAvatarUrl, :breweryDescription, :breweryEmail, :breweryName, :breweryLat, :breweryLong, :breweryPhone, :breweryUrl)";
		$statement = $pdo->prepare($query);

		$parameters = [
			"breweryId" => $this->breweryId->getBytes(),
			"breweryId" => $this->breweryId->getBytes()
		];

		$statement->execute($parameters);
	}

	/**
	 * @param \PDO $pdo
	 */
	public function update(\PDO $pdo): void {

		// create query
		$query = "UPDATE brewery SET breweryAddress = :breweryAvatarUrl, breweryDescription = :breweryEmail WHERE breweryId = :breweryId";
		$statement = $pdo->prepare($query);

	}

	/**
	 * deletes this brewery from mySQL
	 * @param \PDO $pdo
	 */
	public function delete(\PDO $pdo): void {

		// create query
		$query = "DELETE FROM brewery WHERE breweryId = :breweryId";
		$statement = $pdo->prepare($query);

		// connects variables to query
		$parameters = ["breweryId" => $this->breweryId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * @param \PDO $pdo
	 * @param $breweryId
	 * @return Brewery|null
	 */
	public static function getBreweryByBreweryId(\PDO $pdo, $breweryId): ?Brewery {

		try {
			$breweryId = self::validateUuid($breweryId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// created query
		$query = "SELECT breweryId, breweryAddress, breweryAvatarUrl, breweryDescription, breweryEmail, breweryName, breweryLat, breweryLong, breweryPhone, breweryUrl FROM brewery WHERE breweryId = :breweryId";
		$statement = $pdo->prepare($query);

		// connect the brewery id to the place holder in the template
		$parameters = ["breweryId" => $breweryId->getBytes()];
		$statement->execute($parameters);

		// array for brewery
//		$brewery = new \SplFixedArray($statement->rowCount());
//		$statement->setFetchMode(\PDO::FETCH_ASSOC);
//		while(($row = $statement->fetch()) !== false) {
//			try {
//				$brewery = new brewery($row["breweryId"], $row["breweryId"], $row["breweryAddress"], $row["breweryDescription"], $row[breweryEmail], $row[breweryName],);
//				$brewery[$brewery->key()] = $brewey;
//				$brewey->next();
//			} catch(\Exception $exception) {
//				// if the row couldn't be converted, rethrow it
//				throw(new \PDOException($exception->getMessage(), 0, $exception));
//			}
//		}
		return ($brewery);
	}

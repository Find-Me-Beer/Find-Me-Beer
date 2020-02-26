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
class Brewery implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for this brewery; this is the primary key
	 * @var Uuid $breweryId
	 */
	private $breweryId;
	/**
	 * @var string $breweryAddress
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
	 * @param float $newBreweryLat
	 * @param float $newBreweryLong
	 * @param $newBreweryName
	 * @param $newBreweryPhone
	 * @param $newBreweryUrl
	 */


	public function __construct($newBreweryId, string $newBreweryAddress, string $newBreweryAvatarUrl, string $newBreweryDescription, string $newBreweryEmail, string $newBreweryName, float $newBreweryLat, float $newBreweryLong, string $newBreweryPhone, string $newBreweryUrl) {

		try {
			$this->setBreweryId($newBreweryId);
			$this->setBreweryAddress($newBreweryAddress);
			$this->setBreweryAvatarUrl($newBreweryAvatarUrl);
			$this->setBreweryDescription($newBreweryDescription);
			$this->setBreweryEmail($newBreweryEmail);
			$this->setBreweryName($newBreweryName);
			$this->setBreweryLat($newBreweryLat);
			$this->setBreweryLong($newBreweryLong);
			$this->setBreweryPhone($newBreweryPhone);
			$this->setBreweryUrl($newBreweryUrl);

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
	public function getBreweryAddress(): string {
		return ($this->breweryAddress);
	}

	/**
	 * mutator for brewery address
	 * @param string $newBreweryAddress
	 * @throws \InvalidArgumentException if $newBreweryAddress if address is too long
	 */
	public function setBreweryAddress(string $newBreweryAddress): void {
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
	 */
	public function getBreweryAvatarUrl(): string {
		return ($this->breweryAvatarUrl);
	}

	/**
	 * mutator method for breweryAvatarUrl
	 *
	 * @param $newBreweryAvatarUrl
	 */
	public function setBreweryAvatarUrl($newBreweryAvatarUrl): void {

		// this mutator needs to be finished - trimmed and sanitized like the others. check length too.
		// TODO: write a check length if block
		$newBreweryAvatarUrl = trim($newBreweryAvatarUrl);
		$newBreweryAvatarUrl = filter_var($newBreweryAvatarUrl, FILTER_SANITIZE_URL);
		$this->breweryAvatarUrl = $newBreweryAvatarUrl;
	}

	/**
	 * accessor method for brewery description
	 * @return string value for Brewery Description
	 */
	public function getBreweryDescription(): string {
		return ($this->breweryDescription);
	}

	/**
	 * mutator method for breweryDescription
	 * @param string $newBreweryDescription new brewery description
	 * @throws \InvalidArgumentException when brewery is null or not void
	 * @throws \RangeException if range Exception is over 1000 characters
	 **/
	public function setBreweryDescription(string $newBreweryDescription): void {

		if(empty($newBreweryDescription) === true) {
			throw(new \InvalidArgumentException("Brewery Description is not valid"));
		}

		$newBreweryDescription = trim($newBreweryDescription);
		$newBreweryDescription = filter_var($newBreweryDescription, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		//make sure breweryDescription is 1000 characters or less
		if(strlen($newBreweryDescription) > 1000) {
			throw(new\RangeException("Brewery description is too long"));
		}

		//store the brewery description
		$this->breweryDescription = $newBreweryDescription;
	}

	/**
	 * accessor method for brewery email
	 *
	 * @return string
	 */
	public function getBreweryEmail(): string {
		return ($this->breweryEmail);
	}

	/**
	 * mutator method for breweryEmail
	 *
	 * @param string $newBreweryEmail new brewery email
	 * @throws \InvalidArgumentException when brewery is null or not void
	 * @throws \RangeException if range Exception is over 128 characters
	 **/
	public function setBreweryEmail(string $newBreweryEmail): void {

		if(empty($newBreweryEmail) === true) {
			throw(new \InvalidArgumentException("Brewery email is not valid"));
		}

		$newBreweryEmail = trim($newBreweryEmail);
		// we can use php FILTER_SANITIZE_EMAIL
		$newBreweryEmail = filter_var($newBreweryEmail, FILTER_SANITIZE_EMAIL, FILTER_FLAG_NO_ENCODE_QUOTES);

		// verify the brewery email will fit in the database
		if(strlen($newBreweryEmail) > 128) {
			throw(new \RangeException("Brewery email is too large"));
		}

		// store the brewery email
		$this->breweryEmail = $newBreweryEmail;
	}

	/**
	 * accessor method for brewery name
	 *
	 * @return string value of Brewery Name
	 */
	public function getBreweryName(): string {
		return ($this->breweryName);
	}

	/*
	 * mutator method for Brewery Name
	 *
	 * @param string $newBreweryName
	 * @throws \RangeException if $newBreweryName is > 32 characters
	 * @throws \TypeError if $newBreweryName is not a string
	 */
	public function setBreweryName(string $newBreweryName): void {
		// check for null - if so, throw exception
		if(empty($newBreweryName) === true) {
			throw(new \InvalidArgumentException("Brewery name is not valid"));
		}

		//verify new brewery name is secure
		$newBreweryName = trim($newBreweryName);
		$newBreweryName = FILTER_VAR($newBreweryName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		//verify size of string is less than 32 characters
		if(strlen($newBreweryName) > 32) {
			throw(new \RangeException("Brewery name is to long"));
		}

		// store brewery Name
		$this->breweryName = $newBreweryName;
	}

	/**
	 * accessor for brewery latitude
	 *
	 * @return float brewery latitude between -90 and 90
	 **/
	public function getBreweryLat(): float {
		return ($this->breweryLat);
	}

	/**
	 * mutator for brewery latitude
	 * @param float $newBreweryLat new value of the brewery latitude
	 * @throws \RangeException if $newBreweryLat is outside of range
	 **/
	public function setBreweryLat(float $newBreweryLat): void {
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
	 *
	 * @return float brewery longitude in degrees between -180 and 180
	 **/
	public function getBreweryLong(): float {
		return ($this->breweryLong);
	}

	/**
	 * mutator for brewery longitude
	 *
	 * @param float $newBreweryLong new value of the brewery longitude
	 * @throws \RangeException if $newBreweryLong is outside of range
	 **/
	public function setBreweryLong(float $newBreweryLong): void {
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
	 *
	 * @return string value for brewery phone
	 */
	public function getBreweryPhone(): string {
		return ($this->breweryPhone);
	}

	/**
	 * mutator method for brewery Phone
	 *
	 * @param string $newBreweryPhone
	 * @throws \RangeException if $newBreweryPhone is > 64 characters
	 **/
	public function setBreweryPhone(string $newBreweryPhone): void {

		if(empty($newBreweryPhone) === true){
			throw(new \InvalidArgumentException("Phone is invalid"));
		}

		// if phone is null, set to null and return - just like we did for description

		//verify new brewery phone is secure
		$newBreweryPhone = trim($newBreweryPhone);
		$newBreweryPhone = FILTER_VAR($newBreweryPhone, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		//verify size of string is less than 64 characters
		if(strlen($newBreweryPhone) > 64) {
			throw(new \RangeException("Brewery phone is too long"));
		}

		// store brewery Phone
		$this->breweryPhone = $newBreweryPhone;
	}

	/**
	 *  accessor for brewery Url
	 *
	 * @return string value for brewery Url
	 */
	public function getBreweryUrl(): string {
		return ($this->breweryUrl);
	}

	/**
	 * mutator method for breweryUrl
	 *
	 * @param string $newBreweryUrl
	 * @throws \RangeException if $newBreweryUrl is > 2083 characters
	 * @throws \TypeError if $newBreweryUrl is not a string
	 **/
	public function setBreweryUrl(string $newBreweryUrl): void {
		//verify new brewery url is secure
		$newBreweryUrl = trim($newBreweryUrl);
		// we can use php FILTER_SANITIZE_URL
		$newBreweryUrl = FILTER_VAR($newBreweryUrl, FILTER_SANITIZE_URL, FILTER_FLAG_NO_ENCODE_QUOTES);
		//verify size of string is less than 2083 characters
		if(strlen($newBreweryUrl) > 283) {
			throw(new \RangeException("Brewery URL is too long"));
		}
		// store breweryUrl
		$this->breweryUrl = $newBreweryUrl;
	}

	/**
	 * inserts this User into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {

		// create query template
		$query = "INSERT INTO brewery(breweryId, breweryAddress, breweryAvatarUrl, breweryDescription, breweryEmail, breweryName, breweryLat, breweryLong, breweryPhone, breweryUrl) VALUES(:breweryId, :breweryAddress, :breweryAvatarUrl, :breweryDescription, :breweryEmail, :breweryName, :breweryLat, :breweryLong, :breweryPhone, :breweryUrl)";
		$statement = $pdo->prepare($query);

		$parameters = [
			"breweryId" => $this->breweryId->getBytes(),
			"breweryAddress" => $this->breweryAddress,
			"breweryAvatarUrl" => $this->breweryAvatarUrl,
			"breweryDescription" => $this->breweryDescription,
			"breweryEmail" => $this->breweryEmail,
			"breweryName" => $this->breweryName,
			"breweryLat" => $this->breweryLat,
			"breweryLong" => $this->breweryLong,
			"breweryPhone" => $this->breweryPhone,
			"breweryUrl" => $this->breweryUrl
		];

		$statement->execute($parameters);
	}

	/**
	 * update this Brewery in mySQL
	 * @param \PDO $pdo
	 */
	public function update(\PDO $pdo): void {

		// create query
		$query = "UPDATE brewery SET breweryAddress = :breweryAddress, breweryAvatarUrl = :breweryAvatarUrl, breweryDescription = :breweryDescription,  breweryEmail = :breweryEmail, breweryName = :breweryName, breweryLat = :breweryLat, breweryLong = :breweryLong, breweryPhone = :breweryPhone,breweryUrl = :breweryUrl WHERE breweryId = :breweryId";
		$statement = $pdo->prepare($query);

		$parameters = [
			"breweryAddress" => $this->breweryAddress,
			"breweryAvatarUrl" => $this->breweryAvatarUrl,
			"breweryDescription" => $this->breweryDescription,
			"breweryEmail" => $this->breweryEmail,
			"breweryName" => $this->breweryName,
			"breweryLat" => $this->breweryLat,
			"breweryLong" => $this->breweryLong,
			"breweryPhone" => $this->breweryPhone,
			"breweryUrl" => $this->breweryUrl,
			"breweryId" => $this->breweryId->getBytes()
		];

		$statement->execute($parameters);
	}

	/**
	 * deletes this brewery from mySQL
	 *
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
	 * gets brewery by id
	 *
	 * @param \PDO $pdo
	 * @param Uuid $breweryId
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

		// get brewery from MySQL
		try{
				$brewery=null;
				$statement->setFetchMode(\PDO::FETCH_ASSOC);
				$row =$statement->fetch();
				if($row !== false){
						$brewery = new Brewery($row["breweryId"], $row["breweryAddress"], $row["breweryAvatarUrl"], $row["breweryDescription"], $row["breweryEmail"], $row["breweryName"], $row["breweryLat"], $row["breweryLong"], $row["breweryPhone"], $row["breweryUrl"]);
				}
		}catch(\Exception $exception){
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($brewery);
	}

	/*
	 * gets all breweries
	 *
	 * @param \PDO $pdo
	 * @return \SplFixedArray SplFixedArray breweries found
	 * @throws \PDOException
	 */
	public static function getAllBreweries(\PDO $pdo) : \SplFixedArray {
		$query = "SELECT breweryId, breweryAddress, breweryAvatarUrl, breweryDescription, breweryEmail, breweryName, breweryLat, breweryLong, breweryPhone, breweryUrl FROM brewery";
		$statement = $pdo->prepare($query);
		$statement->execute();

		//build array of brewery
		$breweryArray = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$brewery = new Brewery($row["breweryId"], $row["breweryAddress"], $row["breweryAvatarUrl"], $row["breweryDescription"], $row["breweryEmail"], $row["breweryName"], $row["breweryLat"], $row["breweryLong"], $row["breweryPhone"], $row["breweryUrl"]);
				$breweryArray[$breweryArray->key()] = $brewery;
				$breweryArray->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($breweryArray);
	}

	/**
	 *gets Breweries by brewery Name
	 *
	 * @param \PDO $pdo
	 * @param $breweryName
	 * @return Brewery|null
	 */
	public static function getBreweryByBreweryName(\PDO $pdo, $breweryName): \SplFixedArray {
		$breweryName = trim($breweryName);
		$breweryName = filter_var($breweryName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($breweryName)===true){
				throw(new \InvalidArgumentException("Brewery name is invalid"));
		}

		// created query
		$query = "SELECT breweryId, breweryAddress, breweryAvatarUrl, breweryDescription, breweryEmail, breweryName, breweryLat, breweryLong, breweryPhone, breweryUrl FROM brewery WHERE breweryName Like :breweryName";
		$statement = $pdo->prepare($query);

// escape any mySQL wild cards
		$breweryName = str_replace("_", "\\_", str_replace("%", "\\%", $breweryName));

		// connect the brewery name to the place holder in the template
		$breweryName = "%$breweryName%";
		$parameters = ["breweryName" => $breweryName];
		$statement->execute($parameters);

		// array for brewery
		$breweries = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
				try {
						$breweryName = new Brewery($row["breweryId"], $row["breweryAddress"], $row["breweryAvatarUrl"], $row["breweryDescription"], $row["breweryEmail"], $row["breweryName"], $row["breweryLat"], $row["breweryLong"], $row["breweryPhone"], $row["breweryUrl"]);

				$breweries[$breweries->key()] = $breweryName;
				$breweries->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($breweries);
	}

	/**
	 * gets the Brewery by distance
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param float $userLat latitude coordinate of where user is
	 * @param float $userLong longitude coordinate of where user is
	 * @param float $distance distance in miles that the user is searching by
	 * @return \SplFixedArray SplFixedArray of pieces of brewery found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 * **/
	public static function getBreweryByLocation(\PDO $pdo, float $userLong, float $userLat, float $distance) : \SplFixedArray {
		// create query template
		$query = "SELECT breweryId, breweryAddress, breweryAvatarUrl, breweryDescription, breweryEmail, breweryName, breweryLat, breweryLong, breweryPhone, breweryUrl FROM brewery WHERE haversine(:userLong, :userLat, breweryLong, breweryLat) < :distance";
		$statement = $pdo->prepare($query);

		// bind the brewery distance to the place holder in the template
		$parameters = [
			"distance" => $distance,
			"userLat" => $userLat,
			"userLong" => $userLong
		];
		$statement->execute($parameters);

		// build an array of brewery
		$breweryArray = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		while(($row = $statement->fetch()) !== false) {
			try {
				$brewery = new Brewery($row["breweryId"], $row["breweryAddress"], $row["breweryAvatarUrl"], $row["breweryDescription"], $row["breweryEmail"], $row["breweryName"], $row["breweryLat"], $row["breweryLong"], $row["breweryPhone"], $row["breweryUrl"]);
				$breweryArray[$breweryArray->key()] = $brewery;
				$breweryArray->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($breweryArray);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize(): array {
		$fields = get_object_vars($this);
		$fields["breweryId"] = $this->breweryId->toString();
		return ($fields);
	}

}

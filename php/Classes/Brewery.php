<?php

namespace FindMeBeer\FindMeBeer;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Class  Brewery
 * @Author Celeste Whitaker <cwhitaker4@cnm.edu>
 */

/**
 *
 *
 * breweryId Binary(16) PRIMARY KEY
breweryAddress Varchar(512)
breweryAvatarUrl Varchar(128)
breweryDescription Varchar(1000)
breweryEmail Varchar(128)
breweryName Varchar(32)
breweryLat Decimal
breweryLong Decimal
breweryPhone Varchar(32)
breweryUrl Varchar(2083)
 *
 *
 *
 */

class Brewery implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;
	/**
	 * id for this Brewery; this is the primary key
	 * @var Uuid $breweryId
	 */
	private $BreweryId;

	private $BreweryAddress;

	private $BreweryAvatarUrl;

	private $BreweryDescription;

	private $BreweryEmail;

	private $BreweryName;

	private $BreweryLat;

	private $BreweryLong;

	private $BreweryPhone;

	private $BreweryUrl;

	public function __construct($newBreweryId, $newBreweryAddress, $newBreweryAvatarUrl, $newBreweryDescription, $newBreweryEmail, $newBreweryLat, $newBreweryLong, $newBreweryName, $newBreweryPhone, $newBreweryUrl) {
		try {
			$this->setBreweryId($newbreweryId);
			$this->setBreweryAddress($newbreweryAddress);
			$this->setBreweryAvatarUrl($newbreweryAvatarUrl);
			$this->setBreweryDescription($newbreweryDescription);
			$this->setBreweryEmail($newbreweryEmail);
			$this->setBreweryName($newbreweryName);
			$this->setBreweryLat($newbreweryLat);
			$this->setBreweryLong($newbreweryLong);
			$this->setBreweryPhone($newbreweryPhone);
			$this->setBreweryUrl($newbreweryUrl);

		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
			{
			}
		}
	}

	public function getbreweryId(): Uuid {
		return ($this->breweryId);
	}

	/**
	 * mutator of breweryId
	 * @param Uuid $newbreweryId
	 * @throws \RangeException if $newbreweryId is not positive
	 * @throws \TypeError if $newbreweyId is not a uuid or string
	 */

	public function setBreweryId($newbreweryId): void {
		try {
			$uuid = self::validatUuid($newbreweryId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store breweryId
		$this->breweryId = $uuid;

	}

	public function getbreweryAddress(): string {
		return ($this->breweryAddress);
	}

	public function setbreweryAddress(string $newbreweryAddress): void {
		if($newbreweryAddress === null) {
			$this->newbreweryAddress = null;
			return;
		}

		$newbreweryAddress = strtolower(trim($newbreweryAddress));

		if(ctype_xdigit($newbreweryAddress) === false) {

			throw(new\RangeException("brewery Address is not valid"));

		}

		//make sure breweryAddress is only 512 characters

		if(strlen($newbreweryAddress) > 512) {
			throw(new\RangeException("brewery address must be 512 characters or less)

		}

		$this->breweryAddress = $newbreweryAddress;

	}
/**
 * accessor method for breweryAvatarUrl
 *@return String value for breweryAvatarUrl
 *
 */

public function breweryAvatarUrl(){
	return $this-> breweryAvatarUrl;

}

	/**
	 * mutator method for breweryAvatarUrl
	 * @param $newbreweryAvatarUrl
	 * @return String value of breweryAvatarUrl
	 */

	public function setbreweryAvatarUrl($newbreweryAvatarUrl){
	$this-> breweryAvatarUrl = $newbreweryAvatarUrl;

}

/**
 * accessor method for breweryAvatarUrl
 * @return String value of breweryAvatarUrl
 **/

public function setbreweryDescription ($newbreweryDescription) {
	if ($newbreweryDescription === null) {
		$this->newbreweryDescription = null;
		return;
}

		$newbreweryDescription = string(trim($newbreweryDescription));

		if(empty($newbreweryDescription) === true) {

			throw(new\RangeException(\"brewery description is not valid\"));

		}

		//make sure breweryDescription is only 1000 characters

		if(strlen($newbreweryDescription) > 1000){
			throw(new\RangeException(\"brewery description must be 1000 characters or less)

		}

		$this->breweryDescription = $newbreweryDescription;

	}

		throw(new \InvalidArgumentException(\"profile email content is empty or insecure\"));

	}

	/*verify the brewery email content will fit in database

	if(strlen($newbreweryEmail > 128) {

		throw(new \RangeException("brewery email content too large\"));
	}

	// store the brewery email content
	$this->breweryEmail = $newbreweryEmail;

}

public function getBreweryName(): string {
		return($this->breweryName);
}
	/*
	 * mutator method for Brewery Name
	 * @param string $newbreweryName
	 * @throws \RangeException if $newbreweryName is > 32 characters
	 * @throws \TypeError if $newbreweryName is not a string
	 */

	public function setbreweryName(string $newbreweryName):void {

		//verify new brewery Name is secure

		$newbreweryName = trim($newbreweryName);

		$newbreweryName = FILTER_VAR($newbreweryName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		//verify size of string is less than 32 characters

		if(strlen($newbreweryName)> 32){

			throw(new \RangeException(\"Brewery Name is too long\\"));

		}

		// store Brewery Name
		$this->breweryName = $newbreweryName;

	}

	/**
	 * NEED TO ADD LAT AND LONG
	 */


	public function getbreweryPhone(): string {
		return ($this->breweryPhone);
	}

	/**
	 * mutator method for Brewery Phone
	 * @param string $newbreweryPhone
	 * @throws \RangeException if $newbreweryPhone is > 64 characters
	 * @throws \TypeError if $newbreweryPhone is not a string
	 **/

	public function setbreweryPhone(string $newbreweryPhone): void {

		//verify new brewery phone is secure

		$newbreweryPhone = trim($newbreweryPhone);

		$newbreweryPhone = FILTER_VAR($newbreweryPhone, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		//verify size of string is less than 64 characters

		if(strlen($newbreweryPhone) > 64) {

			throw(new \RangeException("Brewery Phone is too long"));

		}

		// store Brewery Phone
		$this->breweryPhone = $newbreweryPhone;

	}


	public function getbreweryUrl(): string {
		return ($this->breweryUrl);
	}

	/**
	 * mutator method for breweryUrl
	 * @param string $newbreweryUrl
	 * @throws \RangeException if $newbreweryUrl is > 2083 characters
	 * @throws \TypeError if $newbreweryUrl is not a string
	 **/

	public function setbreweryUrl(string $newbreweryUrl): void {

		//verify new brewery url is secure

		$newbreweryUrl = trim($newbreweryUrl);

		$newbreweryUrl = FILTER_VAR($newbreweryUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		//verify size of string is less than 2083 characters

		if(strlen($newbreweryUrl) > 2083) {

			throw(new \RangeException(\"Brewery phone number is too long\\"));

		}

		// store breweryUrl
		$this->breweryUrl = $newbreweryUrl;

	}
}
?>
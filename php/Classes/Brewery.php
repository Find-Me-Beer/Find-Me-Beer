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
	 * @var Uuid $BreweryId
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
			{
			}
		}
	}

	public function getBreweryId(): Uuid {
		return ($this->BreweryId);
	}

	/**
	 * mutator of BreweryId
	 * @param Uuid $newBreweryId
	 * @throws \RangeException if $newBreweryId is not positive
	 * @throws \TypeError if $newBreweryId is not a uuid or string
	 */

	public function setBreweryId($newBreweryId): void {
		try {
			$uuid = self::validatUuid($newBreweryId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store BreweryId
		$this->BreweryId = $uuid;

	}

	public function getBreweryAddress(): string {
		return ($this->BreweryAddress);
	}

	public function setBreweryAddress(string $newBreweryAddress) : void {

		$newBreweryAddress = trim($newBreweryAddress);
		$newBreweryAddress = filter_var($newBreweryAddress, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newBreweryAddress) === true) {
			throw(new \InvalidArgumentException("Brewery Address is not valid"));
		}
		// verify the Brewery Address will fit in the database
		if(strlen($newBreweryAddress) > 512) {
			throw(new \RangeException("Brewery address is over 512 characters"));
		}
		// store the Brewery Address
		$this->BreweryAddress = $newBreweryAddress;
	}

/**
 * accessor method for BreweryAvatarUrl
 *@return String value for BreweryAvatarUrl
 *
 */

public function BreweryAvatarUrl(){
	return $this-> BreweryAvatarUrl;

}

	/**
	 * mutator method for BreweryAvatarUrl
	 * @param $newBreweryAvatarUrl
	 * @return String value of BreweryAvatarUrl
	 */

	public function setBreweryAvatarUrl($newBreweryAvatarUrl){
	$this-> BreweryAvatarUrl = $newBreweryAvatarUrl;

}

/**
 * accessor method for BreweryAvatarUrl
 * @return String value of BreweryAvatarUrl
 **/

public function setBreweryDescription ($newBreweryDescription) {
	if ($newBreweryDescription === null) {
		$this->newBreweryDescription = null;
		return;
}

		$newBreweryDescription = string(trim($newBreweryDescription));

		if(empty($newBreweryDescription) === true) {

			throw(new\RangeException("Brewery description is not valid));

		}

		//make sure BreweryDescription is only 1000 characters

		if(strlen($newBreweryDescription) > 1000){
			throw(new\RangeException(Brewery description must be 1000 characters or less)

		}

		$this->BreweryDescription = $newBreweryDescription;

	}

		throw(new \InvalidArgumentException(profile email content is empty or insecure));

	}

	/*verify the brewery email content will fit in database

	if(strlen($newBreweryEmail > 128) {

		throw(new \RangeException("Brewery email content too large));
	}

	// store the Brewery email content
	$this->BreweryEmail = $newBreweryEmail;

}

public function getBreweryName(): string {
		return($this->BreweryName);
}
	/*
	 * mutator method for Brewery Name
	 * @param string $newBreweryName
	 * @throws \RangeException if $newBreweryName is > 32 characters
	 * @throws \TypeError if $newBreweryName is not a string
	 */

	public function seBbreweryName(string $newBreweryName):void {

		//verify new brewery name is secure

		$newBreweryName = trim($newBreweryName);

		$newBreweryName = FILTER_VAR($newBreweryName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		//verify size of string is less than 32 characters

		if(strlen($newBreweryName)> 32){

			throw(new \RangeException("Brewery Name is too long"));

		}

		// store Brewery Name
		$this->BreweryName = $newBreweryName;

	}

	/**
	 * NEED TO ADD LAT AND LONG
	 */


	public function getBreweryPhone(): string {
		return ($this->BreweryPhone);
	}

	/**
	 * mutator method for Brewery Phone
	 * @param string $newBreweryPhone
	 * @throws \RangeException if $newBreweryPhone is > 64 characters
	 * @throws \TypeError if $newBreweryPhone is not a string
	 **/

	public function setBreweryPhone(string $newBreweryPhone): void {

		//verify new brewery phone is secure

		$newBreweryPhone = trim($newBreweryPhone);

		$newBreweryPhone = FILTER_VAR($newBreweryPhone, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		//verify size of string is less than 64 characters

		if(strlen($newBreweryPhone) > 64) {

			throw(new \RangeException("Brewery Phone is too long"));

		}

		// store Brewery Phone
		$this->BreweryPhone = $newBreweryPhone;

	}


	public function getBreweryUrl(): string {
		return ($this->BreweryUrl);
	}

	/**
	 * mutator method for BreweryUrl
	 * @param string $newBreweryUrl
	 * @throws \RangeException if $newBreweryUrl is > 2083 characters
	 * @throws \TypeError if $newBreweryUrl is not a string
	 **/

	public function setBreweryUrl(string $newBreweryUrl): void {

		//verify new brewery url is secure

		$newBreweryUrl = trim($newBreweryUrl);

		$newBreweryUrl = FILTER_VAR($newBreweryUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		//verify size of string is less than 2083 characters

		if(strlen($newBreweryUrl) > 2083) {

			throw(new \RangeException(Brewery phone number is too long));

		}

		// store BreweryUrl
		$this->BreweryUrl = $newBreweryUrl;

	}
}
?>
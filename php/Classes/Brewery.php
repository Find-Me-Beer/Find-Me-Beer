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
class Brewery {
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

	public function __construct($newbreweryId, string $newbreweryAddress, string $newbreweryAvatarUrl, ?string $newbreweryDescription, $newbreweryEmail, $newbreweryLat, $newbreweryLong, $newbreweryName, $newbreweryPhone, $newbreweryUrl) {
		try {
			$this->setbreweryId($newbreweryId);
			$this->setbreweryAddress($newbreweryAddress);
			$this->setbreweryAvatarUrl($newbreweryAvatarUrl);
			$this->setbreweryDescription($newbreweryDescription);
			$this->setbreweryEmail($newbreweryEmail);
			$this->setbreweryName($newbreweryName);
			$this->setbreweryLat($newbreweryLat);
			$this->setbreweryLong($newbreweryLong);
			$this->setbreweryPhone($newbreweryPhone);
			$this->setbreweryUrl($newbreweryUrl);

		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
			}
		}

	public function getbreweryId(): Uuid {
		return ($this->breweryId);
	}

	/**
	 * mutator of breweryId
	 * @param Uuid $newbreweryId
	 * @throws \RangeException if $newbreweryId is not positive
	 * @throws \TypeError if $newbreweryId is not a uuid or string
	 */

	public function setbreweryId($newbreweryId): void {
		try {
			$uuid = self::validateUuid($newbreweryId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store breweryId
		$this->breweryId= $uuid;

	}

	public function getbreweryAddress(): string {
		return ($this->breweryAddress);
	}

	public function setbreweryAddress(string $newbreweryAddress): void {

		$newbreweryAddress = trim($newbreweryAddress);
		$newbreweryAddress = filter_var($newbreweryAddress, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newbreweryAddress) === true) {
			throw(new \InvalidArgumentException("brewery Address is not valid"));
		}
		// verify the brewery Address will fit in the database
		if(strlen($newbreweryAddress) > 512) {
			throw(new \RangeException("brewery address is over 512 characters"));
		}
		// store the brewery Address
		$this->breweryAddress = $newbreweryAddress;
	}

	/**
	 * accessor method for breweryAvatarUrl
	 * @return String value for breweryAvatarUrl
	 *
	 */

	public function breweryAvatarUrl() {
		return $this->breweryAvatarUrl;

	}

	/**
	 * mutator method for breweryAvatarUrl
	 * @param $newbreweryAvatarUrl
	 * @return String value of breweryAvatarUrl
	 */

	public function setbreweryAvatarUrl($newbreweryAvatarUrl) {
		$this->breweryAvatarUrl = $newbreweryAvatarUrl;

	}

	/**
	 * accessor method for breweryAvatarUrl
	 * @return String value of breweryAvatarUrl
	 **/

	public function setbreweryDescription($newbreweryDescription) {
		if($newbreweryDescription === null) {
			$this->newbreweryDescription = null;
			return;
		}

		$newbreweryDescription = string(trim($newbreweryDescription) {
		if(empty($newbreweryDescription) === true) {

			throw(new\RangeException("brewery description is not valid));

		}

		/make sure breweryDescription is 1000 characters or less

		if(strlen($newbreweryDescription) > 1000) {
			throw(new\RangeException(brewery description must be 1000 characters or less)

		}

		$this->breweryDescription = $newbreweryDescription;

	}

		throw(new \InvalidArgumentException(content is empty or insecure));

	}
	
	public function setbreweryEmail(string $newbreweryEmail) : void {
		
		$newbreweryEmail = trim($newbreweryEmail);
		$newbreweryEmail = filter_var($newbreweryEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newbreweryEmail) === true) {
			throw(new \InvalidArgumentException(\"Brewery email is not valid\"));
		}
		// verify the brewery email will fit in the database
		if(strlen($newbreweryEmail) > 128) {
			throw(new \RangeException(\"brewery email is too large\"));
		}
		// store the brewery email
		$this->breweryEmail = $newbreweryEmail;
	}

	public function getbreweryName(): string {
		return ($this->breweryName);
	}

	/*
	 * mutator method for brewery Name
	 * @param string $newbreweryName
	 * @throws \RangeException if $newbreweryName is > 32 characters
	 * @throws \TypeError if $newbreweryName is not a string
	 */

	public function sebbreweryName(string $newbreweryName): void {

		//verify new brewery name is secure

		$newbreweryName = trim($newbreweryName);

		$newbreweryName = FILTER_VAR($newbreweryName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		//verify size of string is less than 32 characters

		if(strlen($newbreweryName) > 32) {

			throw(new \RangeException("brewery Name is too long"));

		}

		// store brewery Name
		$this->breweryName = $newbreweryName;

	}

	/**
	 * NEED TO ADD LAT AND LONG
	 */


	public function getbreweryPhone(): string {
		return ($this->breweryPhone);
	}

	/**
	 * mutator method for brewery Phone
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

			throw(new \RangeException("brewery Phone is too long"));

		}

		// store brewery Phone
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

			throw(new \RangeException(brewery phone number is too long));

		}

		// store breweryUrl
		$this->breweryUrl = $newbreweryUrl;

	}
}

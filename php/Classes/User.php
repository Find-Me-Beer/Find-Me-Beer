<?php

namespace FindMeBeer\FindMeBeer;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

class User implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;
	/** User Class to input/store user data */
	//userId Binary(16) NOT NULL,
	//userAuthenticationToken Varchar(255) NOT NULL,
	//userAvatarUrl Varchar(128),
	//userDOB Date NOT NULL,
	//userEmail Varchar(128) NOT NULL,
	//userFirstName Varchar(32) NOT NULL,
	//userHash Varchar(96) NOT NULL,
	//userLastName Varchar(32) NOT NULL,
	//userUsername Varchar(32) NOT NULL,
	//UNIQUE (userEmail),
	//UNIQUE (userUsername),
	//PRIMARY KEY (userId)

	/**
	 * id for User, Primary Key
	 * @var Uuid $profileId
	 **/

	private $userId;

	/**user ActivationToken for validation
	@var hex $userActivationToken
	**/

	private $userActivationToken;



	/**
	 * user Profile Pic . Upload Url
	 * @var string $userAvatarUrl
	 **/

	private $userAvatarUrl;

	/**user userDOB validates Day of Birth must be 21 or older
	@var string  $userDOB
	 **/

	private $userDOB;

	/**
	 * User's Email  not null, unique(userEmail),
	 * @var string $userEmail
	 **/
	private $userEmail;

	/**
	 * User's First Name  not null,
	 * @var String $userFirstName
	 **/

	private $userFirstName;

	/**
	 * User's hash  not null, argon2i Hash
	 * @var $userHash
	 **/

	private $userHash;

	/**
	 * User's Last Name  not null,
	 * @var String $userLastName
	 **/

	private $userLastName;

	/**
	 * User's Username  not null,
	 * @var String $userUsername
	 **/

	private $userUsername;

	/**
	 * constructor for User      *
	 * @param string| Uuid $newUserId id of this User or null if a new User
	 * @param string $newUserActivationToken string with user token
	 * @param string $newUserAvatarUrl string containing url.
	 * @param \DateTime $newUserDOB user DOB not null
	 * @param string $newUserEmail string containing user email
	 * @param string $newUserFirstName string containing actual user FIRST name
	 * @param string $newUserHash string containing actual user algo argon2i hash
	 * @param string $newUserLastName string containing actual user LAST NAME
	 * @param string $newUserUsername string containing actual user name
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \Exception if some other exception occurs
	 * @throws \TypeError if data types violate type hints
	 **/

		public function __construct($newUserId, $newUserActivationToken,$newUserAvatarUrl,$newUserDOB,$newUserEmail,$newUserFirstName,$newUserHash, $newUserLastName,$newUserUsername) {
			try{
					$this->setUserId($newUserId);
					$this->setUserActivationToken($newUserActivationToken);
					$this->setUserAvatarUrl($newUserAvatarUrl);
					$this->setUserDOB($newUserDOB);
					$this->setUserEmail($newUserEmail);
					$this->setUserFirstName($newUserFirstName);
					$this->setUserHash($newUserHash);
					$this->setUserLastName($newUserLastName);
					$this->setUserUsername($newUserUsername);

			}
					//determine what exception type was thrown
			catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
				$exceptionType = get_class($exception);
				throw(new $exceptionType($exception->getMessage(), 0, $exception));
			}
		}



	/**
	 * accessor method for UserId
	 * @return Uuid value of UserId
	 **/
	public function getUserId(): Uuid {
		return($this->userId);
	}

	/**
	 * mutator of userId
	 * @param Uuid $newUserId
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not a uuid or string
	 **/

	public function setUserId( $newUserId): void {
		try {
			$uuid = self::validateUuid($newUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->userId = $uuid;
	}

	/**
	 * accessor method for UserActivationToken
	 * @return String value of UserActivationToken
	 **/
	public function getUserActivationToken(): ?string {
		return $this->userActivationToken;
	}


	/**
	 * mutator method for user activation token
	 *
	 * @param string $newUserActivationToken
	 * @throws \InvalidArgumentException  if the token is not a string or insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 * @throws \TypeError if the activation token is not a string
	 */

	public function setUserActivationToken(?string $newUserActivationToken): void {
		if($newUserActivationToken === null) {
			$this->userActivationToken = null;
			return;
		}
		$newUserActivationToken = strtolower(trim($newUserActivationToken));
		if(ctype_xdigit($newUserActivationToken) === false) {
			throw(new\RangeException("user activation is not valid"));
		}
		//make sure user activation token is only 32 characters
		if(strlen($newUserActivationToken) !== 32) {
			throw(new\RangeException("user activation token has to be 32"));
		}
		$this->userActivationToken = $newUserActivationToken;
	}
	/**
	 * accessor method for userAvatarUrl
	 * @return String value of userAvatarUrl
	 **/
	public function getUserAvatarUrl(){
		return $this-> userAvatarUrl;
	}

	/**
	 * mutator method for userAvatarUrl
	 * @param $newUserAvatarUrl
	 * @return String value of userAvatarUrl
	 */
	public function setUserAvatarUrl($newUserAvatarUrl){
		$this -> userAvatarUrl = $newUserAvatarUrl;
	}

	/**
	 * accessor method for userAvatarUrl
	 * @return String value of userAvatarUrl
	 **/
	public function getUserDOB(){
		return $this->userDOB;
	}
	/**
	 * mutator method for userDOB
	 * @param  \DateTime $newUserDOB user DateOfBirth date as a DateTime object
	 * @throws \OutOfRangeException if $newUserDOB is < 21
	 */
	public function setUserDOB($newUserDOB = null){
		//user enters DOB if null.
		if($newUserDOB === null){
			throw(new \OutOfBoundsException("Enter your date of Birth"));
		}

		$newUserDOB = self::validateDate($newUserDOB);
	}



}
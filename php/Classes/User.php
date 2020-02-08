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
	//userFirstName Varchar(64) NOT NULL,
	//userHash Varchar(96) NOT NULL,
	//userLastName Varchar(64) NOT NULL,
	//userUsername Varchar(64) NOT NULL,
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
			//with dateDiff()
			$dateOfBirth = new\DateTime();
			$dateOfBirth->newUserDOB;
			$today = date("Y-m-d");
			$diff = date_diff(date_create($dateOfBirth), date_create($today));
			//echo 'Age is ' .$diff->format('%y');
			if($diff<21){
				throw (new \OutOfRangeException("You Must Be 21 Years Old to Use This App"));
			}

			$this->userDOB = $newUserDOB;

		}

	/**
	 * accessor method for userEmail
	 * @return String value of userEmail
	 **/
	public function getUserEmail(): string {
		return $this->userEmail;
	}
	/**
	 * mutator method for User email
	 * @param string $newUserEmail
	 * @throws \InvalidArgumentException if $newUserEmail is not a string or insecure
	 * @throws \RangeException if $newUserEmail is > 128 characters
	 * @throws \TypeError if $newUserEmail is not a string
	 **/
	public function setUserEmail(string $newUserEmail): void {
		// verify the profile email content is secure
		$newUserEmail = trim($newUserEmail);
		$newUserEmail = filter_var($newUserEmail, FILTER_SANITIZE_EMAIL, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserEmail) === true) {
			throw(new \InvalidArgumentException("profile email content is empty or insecure") );
		}

		// verify the profile email content will fit in the database
		if(strlen($newUserEmail) > 128) {
			throw(new \RangeException("profile email content too large"));
		}

		// store the profile email content
		$this->UserEmail = $newUserEmail;
	}
	// userFirst Name Accessors/ Mutators

	public function getUserFirstName(): string {
		return $this->userFirstName;

	}

	/**
	 * mutator method for User First Name
	 * @param string $newUserFirstName
	 * @throws \RangeException if $newUserFirstName is > 64 characters
	 * @throws \TypeError if $newUserFirstName is not a string
	 **/

	public function setUserFirstName(string $newUserFirstName):void {
		//verify new user FirstName is secure
		$newUserFirstName = trim($newUserFirstName);
		$newUserFirstName = FILTER_VAR($newUserFirstName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		//verify size of string is less than 64 characters
		if(strlen($newUserFirstName)>64){
				throw(new \RangeException("First Name is too long"));
		}
		// store First Name
		$this->userFirstName = $newUserFirstName;
	}

	//User Hash

	/**
	 * accessor method for User Hash
	 *
	 * @return string value of hash
	 */
	public function getUserHash() : string {
		return $this->userHash;
	}

	/**
	 * mutator method for user hash password
	 *
	 * @param string $newUserHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 128 characters
	 * @throws \TypeError if profile hash is not a string
	 */
	public function setUserHash(string $newUserHash): void {
		//enforce that hash is properly formatted
		$newUserHash = trim($newUserHash);
		if(empty($newUserHash) === true) {
			throw(new \InvalidArgumentException("User password hash empty or insecure"));
		}
		//enforce the hash is an Argon hash
		$userHashInfo = password_get_info($newUserHash);
		if($userHashInfo["algoName"] !== "argon2i") {
			throw(new \InvalidArgumentException("User hash is not a valid hash"));
		}
		//enforce that the hash is exactly 96 characters.
		if(strlen($newUserHash) !== 96) {
			throw(new\RangeException("User hash must be 96 characters"));
		}
		//store the hash
		$this->userHash = $newUserHash;
	}
	//Getter user Last Name
	public function getUserLastName(): string {
		return $this->userLastName;

	}

	/**
	 * mutator method for User First Name
	 * @param string $newUserlastName
	 * @throws \RangeException if $newUserFirstName is > 64 characters
	 * @throws \TypeError if $newUserFirstName is not a string
	 **/

	public function setUserLastName(string $newUserLastName):void {
		//verify new user Last Name is secure
		$newUserLastName = trim($newUserLastName);
		$newUserLastName = FILTER_VAR($newUserLastName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		//verify size of string is less than 64 characters
		if(strlen($newUserLastName)>64){
			throw(new \RangeException("First Name is too long"));
		}
		// store First Name
		$this->userLastName = $newUserLastName;
	}
 // UserUsername
	//Accessor for UserUsername
	//returns string value of Username

	public function getUserUsername(): string {
		return $this-> userUsername;
	}

	/**
	 * mutator method for profile username
	 * @param string $newProfileUsername
	 * @throws \InvalidArgumentException if $newProfileUsername is not a string or insecure
	 * @throws \RangeException if $newProfileUsername is > 48 characters
	 * @throws \TypeError if $newProfileUsername is not a string
	 **/
	public function setUserUsername(string $newUserUsername): void {
		// verify the User username content is secure
		$newUserUsername = trim($newUserUsername);
		$newUserUsername = filter_var($newUserUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserUsername) === true) {
			throw(new \InvalidArgumentException("User username content is empty or insecure"));
		}

		// verify the User username content will fit in the database
		if(strlen($newUserUsername) > 64 {
			throw(new \RangeException("User username content too large"));
		}

		// store the User username content
		$this->userUsername = $newUserUsername;
	}

	public function jsonSerialize() : array{
		$fields = get_object_vars($this);
		$fields["userId"] = $this->userId->toString();
		return($fields);
	}
	// TODO: Implement jsonSerialize() method.}
	/**
	 * inserts this User into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {

		$query = "INSERT INTO user(userId, userActivationToken, userAvatarUrl, userDOB, userEmail, userFirstName, userHash, userLastName, userUsername, profileUsername) VALUES(:userId, :userActivationToken, :userAvatarUrl, :userDOB, :userEmail, :userFirstName, :userHash, :userLastName, :userUsername)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["userId" => $this->userId->getBytes(), "userActivationToken" => $this->userActivationToken, "userAvatarUrl" => $this->userAvatarUrl, "userDOB" => $this->userDOB, "userEmail" => $this->userEmail, "userFirstName" => $this->userFirstName, "userHash" => $this->userHash, "userLastName" => $this->userLastName, "userUsername" => $this->userUsername];
		$statement->execute($parameters);
	}


	/**
	 * updates this User in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {

		// update query
		$query = "UPDATE user SET userId = :userId, userActivationToken = :userActivationToken, userAvatarUrl = :userAvatarUrl, userDOB = :userDOB, userEmail = :userEmail, userFirstName = :userFirstName, userHash = :userHash, userLastName = :userLastName, userUsername = :userUsername WHERE userId = :userId";
		$statement = $pdo->prepare($query);
	}
		//Figure this part out
//		$parameters = [
//			"profileAbout" => $this->profileAbout,
//			"profileActivationToken" => $this->profileActivationToken,
//			"profileAddressLine1" => $this->profileAddressLine1,
//			"profileAddressLine2" => $this->profileAddressLine2,
//			"profileCity" => $this->profileCity,
//			"profileEmail" => $this->profileEmail,
//			"profileHash" => $this->profileHash,
//			"profileImage" => $this->profileImage,
//			"profileName" => $this->profileName,
//			"profileState" => $this->profileState,
//			"profileUsername" => $this->profileUsername,
//			"profileUserType" => $this->profileUserType,
//			"profileZip" => $this->profileZip,
//			"profileId" => $this->profileId->getBytes()
//		];
//		$statement->execute($parameters);
//	}
	/**
	 * delete UserID from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		$query = "DELETE FROM user WHERE userId = :userId";
		$statement = $pdo->prepare($query);

	}
		/**
		 * gets the user by UserId
		 *
		 * @param \PDO $pdo PDO connection object
		 * @param Uuid|string $userId tweet id to search for
		 * @return User|null User found or null if not found
		 * @throws \PDOException when mySQL related errors occur
		 * @throws \TypeError when a variable are not the correct data type
		 **/
	public static function getUserByUserId(\PDO $pdo, $userId) : ?User {
		//sanitize the userId before searching
			try {
				$userId = self::validateUuid($userId);
			} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
						throw(new |\PDOException($exception->getMessage(), 0, $exception));
			}
			// create query template
			$query = "SELECT userId, userActivationToken, userAvatarUrl, userDOB, userEmail, userFirstName, userHash, userLastName, userUsername FROM user WHERE userid= :userId";
			$statement =$pdo->prepare($query);

			//bind the user id to the place holder in the template
			$parameters = ["userId" => $userId ->getBytes()];
			$statement->execute($parameters);
			// grab the author from mySQL

			try{
					$user = null;
					$statement->setFetchMode(\PDO::FETCH_ASSOC);
					$row = $statement->fetch();
					if($row !== false){
							$user = new User($row["userId"], $row["userActivationToken"], $row["userAvatarUrl"], $row["userDOB"], $row["userEmail"], $row["userFirstName"], $row["userHash"],$row["userLastName"], $row["userUsername"]);

					}
			}	catch(\Exception $exception){
				// if row couldnt be converted, rethrow it
					throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
			return ($user);
	}
	/**
	 * gets the user by user id and returns an array
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $userId user id to search by
	 * @return \SplFixedArray SplFixedArray of User Id's found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/

	public static function getUsersByUserId(\PDO $pdo, $userId): \SplFixedArray {

			try {
					$userId = self::validateUuid($userId);
			} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		// create query template
		$query = "SELECT userId, userActivationToken, userAvatarUrl, userDOB, userEmail, userFirstName, userHash, userLastName, userUsername FROM user WHERE userid= :userId";
		$statement =$pdo->prepare($query);

		//bind the user id to the place holder in the template
		$parameters = ["userId" => $userId ->getBytes()];
		$statement->execute($parameters);

		// build an array of Users
		$users = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !==false) {
				try{
						$users = new User($row["userId"], $row["userActivationToken"], $row["userAvatarUrl"], $row["userDOB"], $row["userEmail"], $row["userFirstName"], $row["userHash"],$row["userLastName"], $row["userUsername"])
						$users[$users->key()] = $users;
						$users->next();
					}  catch(\Exception $exception) {
					// if the row couldn't be converted, rethrow it
					throw(new \PDOException($exception->getMessage(), 0, $exception));
				}
		}
		return($users);
	}


}
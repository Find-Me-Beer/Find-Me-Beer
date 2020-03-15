<?php

namespace FindMeBeer\FindMeBeer;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

class User implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;


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
	@var \Datetime userDOB
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
	 * @Author Vladimir Arias-Antonov
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
	 */
//TODO: Type hint
		public function __construct( $newUserId, $newUserActivationToken,string $newUserAvatarUrl, $newUserDOB,string $newUserEmail,string $newUserFirstName,$newUserHash, string $newUserLastName,string $newUserUsername) {
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

	public function getUserAvatarUrl()	: string {
		return $this-> userAvatarUrl;
	}

	/**
	 * mutator method for userAvatarUrl
	 * @param $newUserAvatarUrl
	 * @return String value of userAvatarUrl
	 */
	public function setUserAvatarUrl(string $newUserAvatarUrl) :void {

		$newUserAvatarUrl = trim($newUserAvatarUrl);
		$newUserAvatarUrl = filter_var($newUserAvatarUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		//verify the avatar URL will fit in the database
		if(strlen($newUserAvatarUrl) > 255){
				throw(new \RangeException("image cloudinary content is too large"));
		}
		$this -> userAvatarUrl = $newUserAvatarUrl;



	}

	/**
	 * accessor method for userUserDateofBirth
	 * @return String value of Date of Birth
	 **/
	public function getUserDOB(){
		return $this->userDOB;
	}

	/**
	 * mutator method for userDOB
	 * @param \DateTime $newUserDOB user DateOfBirth date as a DateTime object
	 * @throws \OutOfRangeException if $newUserDOB is < 21
	 * @throws \Exception if generic exception occurs
	 */
	public function setUserDOB($newUserDOB){
		$newUserDOB = self::validateDate($newUserDOB);
		$drinkDate = new \DateTime();
		$drinkDate = $drinkDate->sub(new \DateInterval('P21Y'));
		if($drinkDate < $newUserDOB) {
			throw (new \OutOfRangeException("Must be 21"));
		}
		// store the userDOB date
		try {
			$newUserDOB = self::validateDateTime($newUserDOB);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
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
		$this->userEmail = $newUserEmail;
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
		if(strlen($newUserHash) > 97 || strlen($newUserHash) < 89 ) {
			throw(new \RangeException("user hash is out of range"));
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
	 * @param string $newUserUsername
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
		if(strlen($newUserUsername) > 64 ){
			throw(new \RangeException("User username content too large"));
		}

		// store the User username content
		$this->userUsername = $newUserUsername;
	}

	/**
	 * inserts this User into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {

		$query = "INSERT INTO user(userId, userActivationToken, userAvatarUrl, userDOB, userEmail, userFirstName, userHash, userLastName, userUsername) VALUES(:userId, :userActivationToken, :userAvatarUrl, :userDOB, :userEmail, :userFirstName, :userHash, :userLastName, :userUsername)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["userId" => $this->userId->getBytes(), "userActivationToken" => $this->userActivationToken, "userAvatarUrl" => $this->userAvatarUrl, "userDOB" => $this->userDOB->format("Y-m-d"), "userEmail" => $this->userEmail, "userFirstName" => $this->userFirstName, "userHash" => $this->userHash, "userLastName" => $this->userLastName, "userUsername" => $this->userUsername];
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

//	 * delete UserID from mySQL
//	 *
//	 * @param \PDO $pdo PDO connection object
//	 * @throws \PDOException when mySQL related errors occur
//	 * @throws \TypeError if $pdo is not a PDO connection object
//	 **/
	public function delete(\PDO $pdo): void {
		$query = "DELETE FROM user WHERE userId = :userId";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holders in the template
		$parameters = ["userId" => $this->userId->getBytes()];
		$statement->execute($parameters);

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
						throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
			// create query template
			$query = "SELECT userId, userActivationToken, userAvatarUrl, userDOB, userEmail, userFirstName, userHash, userLastName, userUsername FROM user WHERE userid= :userId";
			$statement =$pdo->prepare($query);

			//bind the user id to the place holder in the template
			$parameters = ["userId" => $userId ->getBytes()];
			$statement->execute($parameters);
			// grab the user id from mySQL

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
	 * Get user by user activation token
	 *
	 * @param \PDO object $pdo
	 * @param string $userActivationToken
	 * @return User|null User or null if not found
	 */
	public static function getUserByUserActivationToken(\PDO $pdo, string $userActivationToken) : ?User {
		//verifies token format and hex
		$userActivationToken = trim($userActivationToken);
		if(ctype_xdigit($userActivationToken)===false){
				throw(new \InvalidArgumentException("User Activation Token empty or invalid"));

		}
		//query template
		$query = "SELECT userId, userActivationToken, userAvatarUrl, userDOB, userEmail, userFirstName, userHash, userLastName, userUsername FROM user WHERE userActivationToken= :userActivationToken";
		$statement =$pdo->prepare($query);

		//Token to Placeholder
		$parameters = ["userActivationToken" => $userActivationToken];
		$statement->execute($parameters);

		//grab user from mySQL
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
	 * gets the User by user email
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param String $userEmail User email to search for
	 * @return User|null User found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getUserByUserEmail(\PDO $pdo, $userEmail) : ?User {
		// sanitize the user Email before searching
		$userEmail = trim($userEmail);
		$userEmail = filter_var($userEmail, FILTER_VALIDATE_EMAIL, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($userEmail) === true) {
			throw(new \PDOException("Invalid Email"));
		}

		// create query template
		$query = "SELECT userId, userActivationToken, userAvatarUrl, userDOB, userEmail, userFirstName, userHash, userLastName, userUsername FROM user WHERE userEmail = :userEmail";
		$statement = $pdo->prepare($query);

		// bind the user email to the place holder in the template
		$parameters = ["userEmail" => $userEmail];
		$statement->execute($parameters);

		// grab the User from mySQL
		try {
			$user = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$user = new User($row["userId"], $row["userActivationToken"], $row["userAvatarUrl"], $row["userDOB"], $row["userEmail"], $row["userFirstName"], $row["userHash"], $row["userLastName"], $row["userUsername"]);

			}
		} catch(\Exception $exception) {
			// if row couldnt be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($user);
	}
	public function jsonSerialize() : array{
		$fields = get_object_vars($this);
		$fields["userId"] = $this->userId->toString();
		unset($fields["userHash"]);
		unset($fields["userActivationToken"]);
		return($fields);
	}
}

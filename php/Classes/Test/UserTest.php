<?php
namespace FindMeBeer\FindMeBeer\Test;

use FindMeBeer\FindMeBeer\User;

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the User  class
 *
 * This is a complete PHPUnit test of the User class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Tweet
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 **/
class UserTest extends FindMeBeerTest {
	/**
	 * Profile that created the Tweet; this is for foreign key relations
	 * @var User user
	 **/

	protected $VALID_USERID = "1";

	/**
	 * @var string $newUserActivationToken string with user token
	 **/
	protected $VALID_ACTIVATIONTOKEN = null;
	/**
	 * @var string $newUserAvatarUrl string with user avatar url
	 **/
	protected $VALID_AVATARURL = null;

	/**
	 * @var \DateTime $newUserDOB user DateOfBirth date as a DateTime object
	 */
	protected $VALID_DOB = "1993-03-05";

	/**
	 * @var string $newUserEmail string containing user email
	 */
	protected $VALID_EMAIL = "email@email.com";

	/**
	 * valid FirstName of userId
	 *@var string $newUserfirstName of userId
	 */

	protected $VALID_FIRSTNAME = "Vladimir";

	/**
	 * @var string hash
	 */
	private $VALID_HASH;
	/**
	 * valid LastName of userId
	 * @var string $userLastName
	 **/
	protected $VALID_LASTNAME = "Arias-Antonov";
	/**
	 * user
	 * @var string userUsername
	 **/
	protected $VALID_USERUSERNAME = "Vlad11793";

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp()  : void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->$VALID_ACTIVATIONTOKEN =bin2hex(random_bytes(16));

		// create and insert a Profile to own the test Tweet
		$this->user = new User(generateUuidV4(), null,"https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif", "1993-03-05", "email@gmail.com",$this->VALID_PROFILE_HASH, "+12125551212");
		$this->user->insert($this->getPDO());
	}

	/**
	 * test inserting a valid Tweet and verify that the actual mySQL data matches
	 **/
	public function testInsertValidUser() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		// create a new User and insert to into mySQL
		$userId = generateUuidV4();
		$user = new User($userId, $this->profile->getUserId(), $this->$VALID_USERID, $this->$VALID_ACTIVATIONTOKEN, $this->$VALID_AVATARURL, $this->$VALID_DOB, $this->$VALID_EMAIL, $this->$VALID_FIRSTNAME, $this->$VALID_HASH, $this->$VALID_LASTNAME);
		$user->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertEquals($pdoUser->getUserId(), $userId);
		$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_ACTIVATIONTOKEN);
		$this->assertEquals($pdoUser->getUserAvatarUrl(), $this->VALID_AVATARURL);
		$this->assertEquals($pdoUser->getUserDOB(), $this->VALID_DOB);
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoUser->getUserFirstName(), $this->VALID_FIRSTNAME);
		$this->assertEquals($pdoUser->getUserHash(), $this->VALID_HASH);
		$this->assertEquals($pdoUser->getUserLastName(), $this->VALID_LASTNAME);
	}
	/**
	 * test inserting a User, editing it, and then updating it
	 **/
	public function testUpdateValidUser() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");
		// create a new User and insert to into mySQL
		$userId = generateUuidV4();
		$user = new User($userId, $this->$VALID_ACTIVATIONTOKEN, $this->$VALID_AVATARURL, $this->$VALID_DOB, $this->$VALID_EMAIL, $this->$VALID_FIRSTNAME, $this->$VALID_HASH, $this->$VALID_LASTNAME);
		$user->insert($this->getPDO());
		// edit the User and update it in mySQL
		$user->setUserActivationToken($this->$VALID_ACTIVATIONTOKEN);
		$user->setUserAvatarUrl($this->$VALID_AVATARURL);
		$user->setUserDOB($this->$VALID_DOB);
		$user->setUserEmail($this->$VALID_EMAIL);
		$user->setUserFirstName($this->$VALID_FIRSTNAME);
		$user->setUserHash($this->$VALID_HASH);
		$user->setUserLastName($this->$VALID_LASTNAME);
		$user->update($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations

		$pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());

		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertEquals($pdoUser->getUserId(), $userId);
		$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_ACTIVATIONTOKEN);
		$this->assertEquals($pdoUser->getUserAvatarUrl(), $this->VALID_AVATARURL);
		$this->assertEquals($pdoUser->getUserDOB(), $this->VALID_DOB);
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoUser->getUserFirstName(), $this->VALID_FIRSTNAME);
		$this->assertEquals($pdoUser->getUserHash(), $this->VALID_HASH);
		$this->assertEquals($pdoUser->getUserLastName(), $this->VALID_LASTNAME);
	}

	/**
	 * test creating a User and then deleting it
	 **/
	public function testDeleteValidUser() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		$userId = generateUuidV4();
		$user = new User($userId, $this->$VALID_ACTIVATIONTOKEN, $this->$VALID_AVATARURL, $this->$VALID_DOB, $this->$VALID_EMAIL, $this->$VALID_FIRSTNAME, $this->$VALID_HASH,$this->$VALID_LASTNAME);
		$user->insert($this->getPDO());


		// delete the User from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$user->delete($this->getPDO());

		// grab the data from mySQL and enforce the User does not exist
		$pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());
		$this->assertNull($pdoUser);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("user"));
	}

	/**
	 * test inserting a User and regrabbing it from mySQL
	 **/
	public function testGetValidUserByUserId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		// create a new User and insert to into mySQL
		$userId = generateUuidV4();
		$user = new User($userId, $this->$VALID_ACTIVATIONTOKEN, $this->$VALID_AVATARURL, $this->$VALID_DOB, $this->$VALID_EMAIL, $this->$VALID_FIRSTNAME, $this->$VALID_HASH, $this->$VALID_LASTNAME);
		$user->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());

		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertEquals($pdoUser->getUserId(), $userId);
		$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_ACTIVATIONTOKEN);
		$this->assertEquals($pdoUser->getUserAvatarUrl(), $this->VALID_AVATARURL);
		$this->assertEquals($pdoUser->getUserDOB()->format("Y-m-d"), $this->VALID_DOB);
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoUser->getUserFirstName(), $this->VALID_FIRSTNAME);
		$this->assertEquals($pdoUser->getUserHash(), $this->VALID_HASH);
		$this->assertEquals($pdoUser->getUserLastName(), $this->VALID_LASTNAME);
	}
	/**
	 * test grabbing a profile by its activation
	 */
	public function testGetValidUserByActivationToken() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		$userId = generateUuidV4();
		$user = new User($userId, $this->$VALID_ACTIVATIONTOKEN, $this->$VALID_AVATARURL, $this->$VALID_DOB, $this->$VALID_EMAIL, $this->$VALID_FIRSTNAME, $this->$VALID_HASH, $this->$VALID_LASTNAME);
		$user->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUser = User::getUserByUserActivationToken($this->getPDO(), $user->getUserActivationToken());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertEquals($pdoUser->getUserId(), $userId);
		$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_ACTIVATIONTOKEN);
		$this->assertEquals($pdoUser->getUserAvatarUrl(), $this->VALID_AVATARURL);
		$this->assertEquals($pdoUser->getUserDOB()->format("Y-m-d"), $this->VALID_DOB);
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoUser->getUserFirstName(), $this->VALID_FIRSTNAME);
		$this->assertEquals($pdoUser->getUserHash(), $this->VALID_HASH);
		$this->assertEquals($pdoUser->getUserLastName(), $this->VALID_LASTNAME);
	}

	/**
	 * test grabbing a User by email
	 **/
	public function testGetValidUserByEmail() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		$userId = generateUuidV4();
		$user = new User($userId, $this->$VALID_ACTIVATIONTOKEN, $this->$VALID_AVATARURL, $this->$VALID_DOB, $this->$VALID_EMAIL, $this-> $VALID_FIRSTNAME, $this-> $VALID_HASH, $this-> $VALID_LASTNAME);
		$user->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUser = User::getUserByUserEmail($this->getPDO(), $user->getUserEmail());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertEquals($pdoUser->getUserId(), $userId);
		$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_ACTIVATIONTOKEN);
		$this->assertEquals($pdoUser->getUserAvatarUrl(), $this->VALID_AVATARURL);
		$this->assertEquals($pdoUser->getUserDOB()->format("Y-m-d"), $this->VALID_DOB);
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoUser->getUserFirstName(), $this->VALID_FIRSTNAME);
		$this->assertEquals($pdoUser->getUserHash(), $this->VALID_HASH);
		$this->assertEquals($pdoUser->getUserLastName(), $this->VALID_LASTNAME);
	}


}
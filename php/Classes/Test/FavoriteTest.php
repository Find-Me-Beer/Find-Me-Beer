<?php

namespace FindMeBeer\FindMeBeer\Test;
use FindMeBeer\FindMeBeer\{Favorite, User, Beer, Brewery};

// grab the class
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * PHP Unit test for Favorite class. All mySQL/ PDO methods are tested for valid input
 *
 * @see Favorite
 * @author Reece Nunn <rnunn4@cnm.edu>
 *
 * based on UssHopper\DataDesign\Test Like Unit Test by Dylan McDonald <dmcdonald21@cnm.edu>
 */

class FavoriteTest extends FindMeBeerTest {

	/**
	 * User that favorited the beer; this is for foreign key relations
	 * @var User $user
	 */
	protected $user;

	/**
	 * valid hash to use
	 * @var $VALID_HASH
	 */
	protected $VALID_HASH;

	/**
	 * valid activationToken to create the user object to own the test
	 * @var string $VALID_ACTIVATION
	 */
	protected $VALID_ACTIVATION;

	/**
	 * Beer that was favorited; this is for foreign key relations
	 * @var Beer $beer
	 */
	protected $beer;

	/**
	 * Brewery that created the beer that is being favorited; this is for foreign key relations
	 * @var Brewery $brewery
	 */
	protected $brewery;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp(): void {
		// run the default setUp() method first
		parent::setUp();

		//create a salt and hash for the user
		$password = "123456789";
		$this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 9]);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));


		//create and insert the user
		$this->user = new User(generateUuidV4(),
		null,
		"https://gravatar.com/avatar/a1af3caae33a1123bb2cb0fc4aab8228?s=400&d=robohash&r=x",
			"1999-02-17",
		"email@smdmd.com",
		"Reece",
		$this->VALID_HASH,
		"Nunn",
		"rmnunn");
		$this->user->insert($this->getPDO());

		//create and insert a brewery
		$breweryId = generateUuidV4();
		$this->brewery = new Brewery($breweryId,
			"111 Marble Ave NW, Albuquerque, NM 87102",
			"https://gravatar.com/avatar/9f53b21feac95285d0080ad4161f1aac?s=400&d=robohash&r=x",
			"Marble Brewery. You hate it or love it.",
			"marble@brewery.com",
			"Marble Brewery",
			35.092812,
			-106.646729,
			"505-322-8765",
			"marblebrewery.com");
		$this->brewery->insert($this->getPDO());

		//create and insert the beer
		$beerId = generateUuidV4();
		$this->beer = new Beer($beerId,
			"8.3",
			$this->brewery->getBreweryId(),
		"Delicious ale that beer snobs don't like",
		"Double White",
		"Ale");
		$this->beer->insert($this->getPDO());
	}

	/**
	 * test inserting a valid Favorite and verify sql data matches
	 */
	public function testInsertValidFavorite() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");

		// create a new Favorite and insert to into mySQL
		$favorite = new Favorite($this->beer->getBeerId(), $this->user->getUserId());
		$favorite->insert($this->getPDO());

		// get the data from mySQL and enforce it matches our expectations
		$pdoFavorite = Favorite:: getFavoriteByFavoriteBeerIdAndFavoriteUserId($this->getPDO(), $this->beer->getBeerId(), $this->user->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertEquals($pdoFavorite->getFavoriteBeerId(), $this->beer->getBeerId());
		$this->assertEquals($pdoFavorite->getFavoriteUserId(), $this->user->getUserId());
	}

	/**
	 * test creating a favorite and then deleting it
	 */
	public function testDeleteValidFavorite() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");

		// create a new Favorite and insert to into mySQL
		$favorite = new Favorite($this->beer->getBeerId(), $this->user->getUserId());
		$favorite->insert($this->getPDO());

		// delete the favorite from the database
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$favorite->delete($this->getPDO());

		// grab data from database and enforce that the Favorite doesn't exist
		$pdoFavorite = Favorite::getFavoriteByFavoriteBeerIdAndFavoriteUserId($this->getPDO(), $this->beer->getBeerId(), $this->user->getUserId());
		$this->assertNull($pdoFavorite);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("favorite"));
	}

	/**
	 * test getting a favorite by user id
	 */
	public function testGetValidFavoriteByUserId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");

		// // create a new Favorite and insert to into mySQL
		$favorite = new Favorite($this->beer->getBeerId(), $this->user->getUserId());
		$favorite->insert($this->getPDO());

		// get the data from mySQL and enforce it matches our expectations
		$results = Favorite::getFavoriteByFavoriteUserId($this->getPDO(), $this->user->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("FindMeBeer\\FindMeBeer\\Favorite", $results);

		// grab the result from the array and validate it
		$pdoFavorite = $results[0];
		$this->assertEquals($pdoFavorite->getFavoriteBeerId(), $this->beer->getBeerId());
		$this->assertEquals($pdoFavorite->getFavoriteUserId(), $this->user->getUserId());
	}

	/**
	 * test getting a favorite by beer id and user id
	 * @throws \Exception
	 */
	public function getValidFavoriteByUserIdAndBeerId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");

		// create a new Favorite and insert to into mySQL
		$favorite = new Favorite($this->beer->getBeerId(), $this->user->getUserId());
		$favorite->insert($this->getPDO());

		// grab data from mySQL and enforce it matches expectations
		$pdoFavorite = Favorite::getFavoriteByFavoriteBeerIdAndFavoriteUserId($this->getPDO(), $this->beer->getBeerId(), $this->user->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertEquals($pdoFavorite->getFavoriteBeerId(), $this->beer->getBeerId());
		$this->assertEquals($pdoFavorite->getFavoriteUserId(), $this->user->getUserId());
	}





}
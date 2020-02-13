<?php

namespace FindMeBeer\FindMeBeer\Test;
use FindMeBeer\FindMeBeer\{Favorite, User, Beer};

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
	 * create dependent objects before running each test
	 **/
	public final function setUp(): void {
		// run the default setUp() method first
		parent::setUp();

	}

}
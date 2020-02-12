<?php

namespace FindMeBeer\FindMeBeer\Test;

use FindMeBeer\FindMeBeer\{
	Brewery, Beer
};

// grab the class you're testing
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * unit test for Beer class
 *
 * This is a PHPUnit test for the Beer Class. All PDO methods are tested for valid inputs
 *
 * @see Beer
 * @author Reece Nunn <rnunn4@cnm.edu
 * @modeled after TweetTest.php by Dylan McDonald <dmcdonald21@cnm.edu>
 */
class BeerTest extends FindMeBeerTest {
	/**
	 * Valid beer id to use; this starts null and is assigned later
	 * @var Uuid $VALID_BEERID
	 */
	protected $VALID_BEERID = null;

	/**
	 * valid beer abv generated for alcohol by volume
	 * @var float $VALID_BEERABV
	 */
	protected $VALID_BEERABV = 9.64;

	/**
	 * valid updated float/decimal of beer abv
	 *
	 */
	protected $VALID_BEERABV2 = 12.75;

	/**
	 * valid beer description
	 * @var string $VALID_BEERDESCRIPTION
	 */
	protected $VALID_BEERDESCRIPTION = "This beer is light and frothy with a slight hint of pine nuts and butterscotch.";

	/**
	 * valid beer name
	 * @var string $VALID_BEERNAME
	 */
	protected $VALID_BEERNAME = "Pine Nut Butterscotch Beer";






	public final function setUp(): void {
		//run setUp() method first
		parent::setUp();

	}


// create and insert a Brewery to own the test Beer
$this->brewery = new Brewery()
$this->brewery->insert($this->getPDO());
}
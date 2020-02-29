<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use FindMeBeer\FindMeBeer\{Brewery, Beer, BeerTag, Tag};

/**
 * api for the Beer /**
 * @author Reece Nunn
 */

//verify the session and start if active
if (session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/beerme.ini");
	$pdo = $secrets->getPdoObject();

	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize the input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$beerBreweryId = filter_input(INPUT_GET, "beerBreweryId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$beerAbv = filter_input(INPUT_GET, "beerAbv", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$beerDescription = filter_input(INPUT_GET, "beerDescription", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$beerName = filter_input(INPUT_GET, "beerName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$beerType = filter_input(INPUT_GET, "beerType", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	$tagId = filter_input(INPUT_GET, "tagId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	// make sure the id provided is valid
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 402));
	}

	// handle GET request - if id is present, that beer is returned, otherwise all beers are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific beer or all beers and update reply
		if(empty($id) === false) {
			$reply->data = Beer::getBeerByBeerId($pdo, $id);

		} else if (empty($beerBreweryId) === false) {
			$reply->data = Beer::getBeerByBeerBreweryId($pdo, $beerBreweryId)->toArray();

		} else if (empty($beerType) === false) {
			$reply->data = Beer::getBeerByBeerType($pdo, $beerType)->toArray();

		} else if (empty($tagId) === false) {
			$reply->data = Beer::getBeerByTagId($pdo, $tagId)->toArray();

		} else {
			$reply->data = Beer::getAllBeer($pdo)->toArray();
		}

	} else {
		throw (new InvalidArgumentException("Invalid HTTP method request", 418));
	}

	// update the $reply->status $reply->message
	} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

// encode and return reply to front end caller
header("Content-type: application/json");
echo json_encode($reply);

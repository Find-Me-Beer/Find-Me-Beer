<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use FindMeBeer\FindMeBeer\Brewery;
use FindMeBeer\FindMeBeer\User;

/**
 * api for the Tweet class
 *
 * @author variasantonov
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
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

// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$breweryAddress = filter_input(INPUT_GET, "breweryAddress", FILTER_SANITIZE_STRING);
	$breweryAvatarUrl = filter_input(INPUT_GET, "breweryAvatarUrl", FILTER_SANITIZE_STRING);
	$breweryDescription = filter_input(INPUT_GET, "breweryDescription", FILTER_SANITIZE_STRING);
	$breweryEmail = filter_input(INPUT_GET, "breweryEmail", FILTER_SANITIZE_STRING);
	$breweryName = filter_input(INPUT_GET, "breweryName", FILTER_SANITIZE_STRING);
	$breweryPhone = filter_input(INPUT_GET, "breweryPhone", FILTER_SANITIZE_STRING);
	$breweryUrl = filter_input(INPUT_GET, "breweryUrl", FILTER_SANITIZE_STRING);
	$distance = filter_input(INPUT_GET, "distance", FILTER_SANITIZE_STRING);
	$userLat = filter_input(INPUT_GET, "userLat", FILTER_SANITIZE_STRING);
	$userLong = filter_input(INPUT_GET, "userLong", FILTER_SANITIZE_STRING);

	// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

// Only needs GET
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//gets a post by content
		if(empty($id) === false) {
			$reply->data = Brewery::getBreweryByBreweryId($pdo, $id);

		} else if(empty($userLat) === false && empty($userLong) === false && empty($distance) === false) {
			$reply->data = Brewery::getBreweryByLocation($pdo, $userLat, $userLong, $distance);

		} else if(empty($breweryName) === false) {

			$reply->data = Brewery::getBreweryByBreweryName($pdo, $breweryName);

		} else if(empty($breweries) === false) {
			$breweries = Brewery::getAllBreweries($pdo)->toArray();
			$reply->data = $breweries;
		}

	}else {
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






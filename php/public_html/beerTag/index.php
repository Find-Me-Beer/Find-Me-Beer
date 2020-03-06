<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";


use \FindMeBeer\FindMeBeer\BeerTag;

/**
 * Api for the BeerTag class
 *
 * @author george kephart
 */

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


	//sanitize the search parameters
	$beerTagBeerId = $id = filter_input(INPUT_GET, "beerTagBeerId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$beerTagTagId = $id = filter_input(INPUT_GET, "beerTagTagId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);

	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//gets  a specific BeerTag associated based on its composite key
		if ($beerTagBeerId !== null && $beerTagTagId !== null) {
			$beerTag = BeerTag::getBeerTagByBeerTagBeerIdAndBeerTagTagId($pdo, $beerTagBeerId, $beerTagTagId);


			if($beerTag!== null) {
				$reply->data = $beerTag;
			}
			//if none of the search parameters are met throw an exception
		} else if(empty($beerTagBeerId) === false) {
			$reply->data = BeerTag::getBeerTagByBeerTagBeerId($pdo, $beerTagBeerId)->toArray();
			//get all the likes associated with the tweetId
		} else if(empty($beerTagTagId) === false) {
			$reply->data = BeerTag::getBeerTagByBeerTagTagId($pdo, $beerTagTagId)->toArray();
		} else {
			throw new InvalidArgumentException("incorrect search parameters ", 404);
		}

	} else if($method === "POST" || $method === "PUT") {

		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		if(empty($requestObject->beerTagBeerId) === true) {
			throw (new \InvalidArgumentException("No beer linked to the beerTag", 405));
		}

		if(empty($requestObject->beerTagTagId) === true) {
			throw (new \InvalidArgumentException("No beer linked to the beerTag", 405));
		}


		if($method === "POST") {

			//enforce that the end user has a XSRF token.
			verifyXsrf();

			//enforce the end user has a JWT token
			//validateJwtHeader();

			// enforce the user is signed in
			if(empty($_SESSION["beer"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in too beerTag posts", 403));
			}

			validateJwtHeader();

			$beerTag = new beerTag($_SESSION["beer"]->getBeerTagBeerId(), $requestObject->beerTagTagId);
			$beerTag->insert($pdo);
			$reply->message = "Added beerTag successful";


		} else if($method === "PUT") {

			//enforce the end user has a XSRF token.
			verifyXsrf();

			//enforce the end user has a JWT token
			validateJwtHeader();

			//grab the beerTag by its composite key
			$beerTag = beerTag::getBeerTagByBeerTagBeerIdAndBeerTagTagId($pdo, $requestObject->beerTagBeerId, $requestObject->beerTagTagId);
			if($beerTag === null) {
				throw (new RuntimeException("beerTag does not exist"));
			}

			//enforce the user is signed in and only trying to edit their own beerTag
			if(empty($_SESSION["beer"]) === true || $_SESSION["beer"]->getBeerTagBeerId()->toString() !== $beerTag->getBeerTagTagId()->toString()) {
				throw(new \InvalidArgumentException("You are not allowed to delete this BeerTag", 403));
			}

			//validateJwtHeader();

			//preform the actual delete
			$beerTag->delete($pdo);

			//update the message
			$reply->message = "beerTag successfully deleted";
		}

		// if any other HTTP request is sent throw an exception
	} else {
		throw new \InvalidArgumentException("invalid http request", 400);
	}
	//catch any exceptions that is thrown and update the reply status and message
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

// encode and return reply to front end caller
echo json_encode($reply);

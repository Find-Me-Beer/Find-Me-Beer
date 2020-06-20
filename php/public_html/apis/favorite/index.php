<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use FindMeBeer\FindMeBeer\{Favorite};

/**
 * Api for the Favorite class
 *
 * @author Patrick Leyba <pleyba4@cnm.edu>
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
	$favoriteBeerId = $id = filter_input(INPUT_GET, "favoriteBeerId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$favoriteUserId = $id = filter_input(INPUT_GET, "favoriteUserId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);

	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//gets a specific like associated based on its composite key
		if (empty($favoriteBeerId) === false && empty($favoriteUserId) === false) {
			$favorite = Favorite::getFavoriteByFavoriteBeerIdAndFavoriteUserId($pdo, $favoriteBeerId, $favoriteUserId);

			/*whut?
			if($favorite!== null) {
				$reply->data = $favorite;
			}*/

		} else if(empty($favoriteUserId) === false) {
			$reply->data = Favorite::getFavoriteByFavoriteUserId($pdo, $favoriteUserId)->toArray();
		} else {
			$reply->data = Favorite::getAllFavorites($pdo)->toArray();
		}

	} else if($method === "POST" || $method === "PUT") {

		//enforce that the end user has an XSRF token.
		verifyXsrf();
		validateJwtHeader();

		// enforce the user is signed in
		if(empty($_SESSION["user"]) === true) {
			throw(new \InvalidArgumentException("you must be logged in to favorite beer", 403));
		}

		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		if(empty($requestObject->favoriteBeerId) === true) {
			throw (new \InvalidArgumentException("No Beer linked to the Favorite", 405));
		}

		if(empty($requestObject->favoriteUserId) === true) {
			throw (new \InvalidArgumentException("No User linked to the Favorite", 405));
		}

		if($method === "POST") {

			//check if the favorite already exists
			$favoriteCheck = Favorite::getFavoriteByFavoriteBeerIdAndFavoriteUserId($pdo, $requestObject->favoriteBeerId, $_SESSION["user"]->getUserId());
			if(!empty($favoriteCheck) || $favoriteCheck !== null) {
				throw (new \InvalidArgumentException("You've already liked this beer.", 403));
			}

			$favorite = new Favorite($requestObject->favoriteBeerId, $_SESSION["user"]->getUserId());
			$favorite->insert($pdo);
			$reply->message = "favorite beer successful";

		} else if($method === "PUT") {

			//grab the like by its composite key
			$favorite = Favorite::getFavoriteByFavoriteBeerIdAndFavoriteUserId($pdo, $requestObject->favoriteBeerId, $requestObject->favoriteUserId);
			if($favorite === null) {
				throw (new RuntimeException("Favorite does not exist"));
			}

			//enforce the user is signed in and only trying to delete their own favorite
			if(empty($_SESSION["user"]) === true || $_SESSION["user"]->getUserId()->toString() !== $favorite->getFavoriteUserId()->toString()) {
				throw(new \InvalidArgumentException("You are not allowed to unfavorite this beer.", 403));
			}

			//preform the actual delete
			$favorite->delete($pdo);

			//update the message
			$reply->message = "Favorite successfully deleted";
		}

		// if any other HTTP request is sent throw an exception
	} else {
		throw new \InvalidArgumentException("invalid http request", 405);
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
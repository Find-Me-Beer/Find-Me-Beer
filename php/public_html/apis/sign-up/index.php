<?php


require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use FindMeBeer\FindMeBeer\User;

/**
 * api for signing up for Find Me Beer account
 *
 * @author Reece Nunn <rmnunn5@gmail.com>
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


	//grab the mySQL connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/beerme.ini");
	$pdo = $secrets->getPdoObject();

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	if($method === "POST") {


		//decode the json and turn it into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

//		if Avatar url is empty set it to null
		if(empty($requestObject->userAvatarUrl) === true) {
			$requestObject->userAvatarUrl = null;
		}

		//the dob is a required field
		if(empty($requestObject->userDOB) === true) {
			throw(new \InvalidArgumentException ("Must input valid date of birth", 405));
		}

		//user email is a required field
		if(empty($requestObject->userEmail) === true) {
			throw(new \InvalidArgumentException ("Must input a valid email", 405));
		}

		//user first name is a required field
		if(empty($requestObject->userFirstName) === true) {
			throw(new \InvalidArgumentException ("Must input a valid first name", 405));
		}

		//verify that user password is present
		if(empty($requestObject->userPassword) === true) {
			throw(new \InvalidArgumentException ("Must input valid password", 405));
		}

		//verify that the confirm password is present
		if(empty($requestObject->userPasswordConfirm) === true) {
			throw(new \InvalidArgumentException ("Must input valid password", 405));
		}

		//user last name is a required field
		if(empty($requestObject->userLastName) === true) {
			throw(new \InvalidArgumentException ("Must input a valid last name", 405));
		}

		//user username is a required field
		if(empty($requestObject->userUsername) === true) {
			throw(new \InvalidArgumentException ("Must input a valid username", 405));
		}

		//make sure the password and confirm password match
		if($requestObject->userPassword !== $requestObject->userPasswordConfirm) {
			throw(new \InvalidArgumentException("passwords do not match"));
		}

		//hash the password
		$hash = password_hash($requestObject->userPassword, PASSWORD_ARGON2I, ["time_cost" => 9]);

		//create user activation token
		$userActivationToken = bin2hex(random_bytes(16));

		//create the user object and prepare to insert into the database
		$user = new User(
			generateUuidV4(),
			$userActivationToken,
			$requestObject->userAvatarUrl,
			$requestObject->userDOB,
			$requestObject->userEmail,
			$requestObject->userFirstName,
			$hash,
			$requestObject->userLastName,
			$requestObject->userUsername);

		//insert the user into the database
		$user->insert($pdo);

		//compose the email message to send with th activation token
		$messageSubject = "Ready to Find Some Beer? -- Account Activation";

		//the link that will be clicked to confirm the account.
		//make sure URL is /public_html/api/activation/$activation
		$basePath = dirname($_SERVER["SCRIPT_NAME"], 3);

		//create the path
		$urlglue = $basePath . "/apis/activation/?activation=" . $userActivationToken;

		//create the redirect link
		$confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $urlglue;

		//compose message to send with email
		$message = <<< EOF
<h2>Thanks for signing up! Ready to Find Beer?.</h2>
<p>Before you go on your quest for beer, you need to activate your account by clicking the link below.</p>
<p><a href="$confirmLink">$confirmLink</a></p>
EOF;

		//create swift email
		$swiftMessage = new Swift_Message();

		// attach the sender to the message
		// this takes the form of an associative array where the email is the key to a real name
		$swiftMessage->setFrom(["rmnunn5@gmail.com" => "Reece Nunn"]);

		/**
		 *attach recipients to the message
		 **/

		//define who the recipient is
		$recipients = [$requestObject->userEmail];
		//set the recipient to the swift message
		$swiftMessage->setTo($recipients);

		//attach the subject line to the email message
		$swiftMessage->setSubject($messageSubject);

		/**
		 * attach the message to the email
		 */

		//attach the html version of the message
		$swiftMessage->setBody($message, "text/html");

		//attach the plain text version of the message
		$swiftMessage->addPart(html_entity_decode($message), "text/plain");

		/**
		 * send the Email via SMTP
		 **/

		//setup smtp
		$smtp = new Swift_SmtpTransport(
			"localhost", 25);
		$mailer = new Swift_Mailer($smtp);

		//send the message
		$numSent = $mailer->send($swiftMessage, $failedRecipients);

		/**
		 * the send method returns the number of recipients that accepted the Email
		 * if the number attempted is not the number accepted, this is an Exception
		 **/
		if($numSent !== count($recipients)) {
			// the $failedRecipients parameter passed in the send() method now contains contains an array of the Emails that failed
			throw(new RuntimeException("unable to send email", 400));
		}

		// update reply
		$reply->message = "Thank you for creating Find Me Beer profile!";
	} else {
		throw (new InvalidArgumentException("invalid http request"));
	}

} catch(\Exception |\TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
}

header("Content-type: application/json");
echo json_encode($reply);
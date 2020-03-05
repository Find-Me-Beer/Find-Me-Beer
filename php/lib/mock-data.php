<?php

use FindMeBeer\FindMeBeer\{Brewery, Beer, Tag, BeerTag};

require_once (dirname(__dir__) . "/classes/autoload.php");

require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

require_once ("uuid.php");

$pdo = connectToMySQL("/etc/apache2/capstone-mysql/beerme.ini");

//Create Marble Brewery
$marble = new Brewery(
	generateUuidV4(),
	"111 Marble Ave NW, Albuquerque, NM 87102",
	"https://beerpulse.com/wp-content/uploads/2012/05/marble-brewery-logo1.jpg",
	"Founded in 2008 in the heart of downtown Albuquerque, Marble Brewery is devoted to brewing 
	premium craft beer that satisfies the thirsts and discriminating tastes of our diverse and loyal customers. 
	Not only do we brew quality craft beer classics, our fresh cutting-edge specials relentlessly push boundaries and 
	raise expectations. We package a variety of styles and distribute throughout New Mexico, Arizona, Southwest Texas 
	and Southwest Colorado.",
	"info@marblebrewery.com",
	"Marble Brewery",
	35.09316,
	-106.65065,
	"(505) 243-2739",
	"marblebrewery.com");

//insert Marble Brewery into database
$marble->insert($pdo);
echo "Marble Brewery";
var_dump($marble->getBreweryId()->toString());

//create Marble Double White
$marbleDoubleWhite = new Beer(
	generateUuidV4(),
	$marble->getBreweryId(),
	7,
	"A delicate, dry, pale & hazy Belgian­-inspired wheat ale accented with traditional spices.",
	"Double White",
	"Belgian Witbier");

//Insert Double White into database
$marbleDoubleWhite->insert($pdo);
echo "Marble Double White";
var_dump($marbleDoubleWhite->getBeerId()->toString());

//create Marble India Pale Ale
$marbleIPA = new Beer(
	generateUuidV4(),
	$marble->getBreweryId(),
	6.8,
	"A variety of hops deliver a fragrant citrus aroma & snappy hop character to this eminently quaffable IPA.",
	"India Pale Ale",
	"India Pale Ale (IPA)");

//Insert Marble India Pale Ale into database
$marbleIPA->insert($pdo);
echo "Marble India Pale Ale";
var_dump($marbleIPA->getBeerId()->toString());

//create Marble Passionate Gose
$marblePassionateGose = new Beer(
	generateUuidV4(),
	$marble->getBreweryId(),
	4.3,
	"Fantastically fruity & bright, this sour ale is seasoned with passion fruit and a hint of salt.",
	"Passionate Gose",
	"Sour Gose");

//Insert Marble Passionate Gose into database
$marblePassionateGose->insert($pdo);
echo "Marble Passionate Gose";
var_dump($marblePassionateGose->getBeerId()->toString());

//create Marble Cholo Stout
$marbleCholoStout = new Beer(
	generateUuidV4(),
	$marble->getBreweryId(),
	6.9,
	"This all-sick stout rides low & slow with a dark blend of roasted malts & bounces high with a pop 
	of bright PNW hops.",
	"Cholo Stout",
	"American Stout");

//Insert Marble Cholo Stout into database
$marbleCholoStout->insert($pdo);
echo "Marble Cholo Stout";
var_dump($marbleCholoStout->getBeerId()->toString());

//create Marble Red Ale
$marbleRedAle = new Beer(
	generateUuidV4(),
	$marble->getBreweryId(),
	6.5,
	"Bursting with Pacific Northwest hops, balanced by a blend of caramel & toasted malts.",
	"Red Ale",
	"Red Ale");

//Insert Marble Red Ale into database
$marbleRedAle->insert($pdo);
echo "Marble Cholo Stout";
var_dump($marbleRedAle->getBeerId()->toString());


//Create The Craftroom
$craftroom = new Brewery(
	generateUuidV4(),
	"2809 Broadbent Pkwy NE, Albuquerque, NM 87107",
	"https://bit.ly/2TyZtXE",
	"The Craftroom focuses on providing an excellent selection of craft beer and hard cider that 
	caters to everyone's taste buds. Whether you like IPA's or want to try something unique like Sandia (Watermelon) 
	Cider, or get creative and mix a beer and cider together, we have something for YOU!",
	"sandiahardcider002@gmail.com",
	"The Craftroom",
	35.11296,
	-106.62869,
	"(505) 717-1985",
	"https://www.thecraftroomnm.com/");

//insert The Craftroom into database
$craftroom->insert($pdo);
echo "The Craftroom";
var_dump($craftroom->getBreweryId()->toString());

//create Craftroom Double Belgium
$craftroomBelgium = new Beer(
	generateUuidV4(),
	$craftroom->getBreweryId(),
	7.5,
	"Bright and light, but bold and dry.",
	"Double Belgium",
	"Belgian Witbier");

//Insert Craftroom Double Belgium into database
$craftroomBelgium->insert($pdo);
echo "The Craftroom Double Belgium";
var_dump($craftroomBelgium->getBeerId()->toString());

//create Craftroom Honey IPA
$craftroomIPA = new Beer(
	generateUuidV4(),
	$craftroom->getBreweryId(),
	6.7,
	"Mix of caramel, caravienne and vienna malts laden with tropical fruits and doused with a splash of honey.",
	"Honey IPA",
	"India Pale Ale (IPA)");

//Insert Craftroom Honey IPA into database
$craftroomIPA->insert($pdo);
echo "Craftroom Honey IPA";
var_dump($craftroomIPA->getBeerId()->toString());

//create Craftroom Red Ale
$craftroomRedAle = new Beer(
	generateUuidV4(),
	$craftroom->getBreweryId(),
	7.3,
	"Sweet caramel and toasted malt flavors leading to a bold bitter bite on the tongue.",
	"Red Ale",
	"India Pale Ale (IPA)");

//Insert Craftroom Red Ale into database
$craftroomRedAle->insert($pdo);
echo "Craftroom Red Ale";
var_dump($craftroomRedAle->getBeerId()->toString());

//create Craftroom Blueberry Wheat
$craftroomBlueberryWheat = new Beer(
	generateUuidV4(),
	$craftroom->getBreweryId(),
	5.2,
	"American-style Amber with medium body, caramel and roasted malt characteristics together with a 
	light doing of American hops.",
	"Blueberry Wheat",
	"American-style Amber");

//Insert Craftroom Blueberry Wheat into database
$craftroomBlueberryWheat->insert($pdo);
echo "Craftroom Blueberry Wheat";
var_dump($craftroomBlueberryWheat->getBeerId()->toString());

//create Craftroom Hefen
$craftroomHefen = new Beer(
	generateUuidV4(),
	$craftroom->getBreweryId(),
	6.7,
	"Classic German style hefeweizen with hints of banana.",
	"Hefen",
	"Hefen");

//Insert Craftroom Red Ale into database
$craftroomHefen->insert($pdo);
echo "Craftroom Hefen";
var_dump($craftroomHefen->getBeerId()->toString());

//Create Santa Fe Brewing Company
$santaFe = new Brewery(
	generateUuidV4(),
	"35 Fire Place Santa Fe, New Mexico, 87508",
	"https://bit.ly/2IkcgIj",
	"Santa Fe Brewing Company is New Mexico's oldest and most award-winning microbrewery. 
	We brew in Santa Fe, serve in our taprooms in Santa Fe and Albuquerque, and distribute around the southwest. 
	We're known for our iconic flagships like Santa Fe Gold, State Pen Porter, and Happy Camper IPA, but we always have 
	something new and exciting on tap or up our sleeves.",
	"hello@santafebrewing.com",
	"Santa Fe Brewing Company",
	35.59705,
	-106.05154,
	"(505) 424-3333",
	"https://santafebrewing.com/");

//insert Santa Fe Brewing Company into database
$santaFe->insert($pdo);
echo "Santa Fe Brewing Company";
var_dump($craftroom->getBreweryId()->toString());

// Create Santa Fe Freestyle Pilsner
$santaFePilsner = new Beer(
	generateUuidV4(),
	$santaFe->getBreweryId(),
	6.6,
	"For people who like their pilsners crisp, refreshing, and highly ranked.",
	"Freestyle Pilsner",
	"German Pilsner");

//Insert Santa Fe Freestyle Pilsner into database
$santaFePilsner->insert($pdo);
echo "Santa Fe Brewing Co Freestyle Pilsner";
var_dump($santaFePilsner->getBeerId()->toString());

// Create Santa Fe 7k IPA
$santaFe7k = new Beer(
	generateUuidV4(),
	$santaFe->getBreweryId(),
	7,
	"7K is a dry, West Coast-ish style IPA with notes of grapefruit, citrus and tropical flavors. ",
	"7K IPA",
	"India Pale Ale (IPA)");

//Insert Santa Fe 7K IPA into database
$santaFe7k->insert($pdo);
echo "Santa Fe Brewing Co 7K IPA";
var_dump($santaFe7k->getBeerId()->toString());

// Create Santa Fe Oktoberfest
$santaFeOktoberfest = new Beer(
	generateUuidV4(),
	$santaFe->getBreweryId(),
	6,
	"The crisp maltiness of classic Munich malt compounded with the delicious notes of Bavarian hops 
	gives this clean-finishing beer just the right flavor for the end of the summer. ",
	"Oktoberfest",
	"German Märzen");

//Insert Santa Fe Pale Ale
$santaFeOktoberfest->insert($pdo);
echo "Santa Fe Brewing Co Oktoberfest";
var_dump($santaFeOktoberfest->getBeerId()->toString());

// Create Santa Fe Oktoberfest
$santaFePaleAle = new Beer(
	generateUuidV4(),
	$santaFe->getBreweryId(),
	5.4,
	"Santa Fe Pale Ale is as full bodied as its most robust English counterparts, while asserting its
	 American origin with a healthy nose resplendent with Cascade and Willamette hops.  ",
	"Santa Fe Pale Ale",
	"American Pale Ale (APA)");

//Insert Santa Fe Oktoberfest into database
$santaFePaleAle->insert($pdo);
echo "Santa Fe Brewing Co Pale Ale";
var_dump($santaFePaleAle->getBeerId()->toString());

// Create Santa Fe Pale Ale
$santaFePaleAle = new Beer(
	generateUuidV4(),
	$santaFe->getBreweryId(),
	5.4,
	"Santa Fe Pale Ale is as full bodied as its most robust English counterparts, while asserting its
	 American origin with a healthy nose resplendent with Cascade and Willamette hops.",
	"Santa Fe Pale Ale",
	"American Pale Ale (APA)");

//Insert Santa Fe Pale Ale into database
$santaFePaleAle->insert($pdo);
echo "Santa Fe Brewing Co Pale Ale";
var_dump($santaFePaleAle->getBeerId()->toString());

// Create Santa Fe Pepe Loco
$santaFePepeLoco = new Beer(
	generateUuidV4(),
	$santaFe->getBreweryId(),
	4.8,
	"Santa Fe Pale Ale is as full bodied as its most robust English counterparts, while asserting its
	 American origin with a healthy nose resplendent with Cascade and Willamette hops.",
	"Santa Fe Pale Ale",
	"American Pale Ale (APA)");

//Insert Santa Fe Pepe Loco into database
$santaFePepeLoco->insert($pdo);
echo "Santa Fe Brewing Co Pale Ale";
var_dump($santaFePepeLoco->getBeerId()->toString());

//Create Bosque Brewing Co.
$bosque = new Brewery(
	generateUuidV4(),
	"106 Girard Blvd SE, Ste. B Albuquerque NM 87106",
	"https://i.pinimg.com/474x/9c/b6/16/9cb6166e8ae36ffab7db96119ee8363a--brewery-mexico.jpg",
	"Bosque Brewing Company is a microbrewery based in New Mexico with taprooms in Albuquerque and
	 Las Cruces. The company produces beers inspired by American and European style traditions that are distributed 
	 throughout the state of New Mexico.",
	"hello@santafebrewing.com",
	"Santa Fe Brewing Company",
	35.59705,
	-106.05154,
	"(505) 424-3333",
	"https://santafebrewing.com/");

//insert Bosque Brewing Co into database
$bosque->insert($pdo);
echo "Bosque Brewing Co.";
var_dump($bosque->getBreweryId()->toString());

// Create Bosque IPA
$bosqueIPA = new Beer(
	generateUuidV4(),
	$bosque->getBreweryId(),
	6.5,
	"IPA with pale, caramel, and wheat malts.",
	"Bosque IPA",
	"India Pale ALe (IPA)");

//Insert Bosque IPA into database
$bosqueIPA->insert($pdo);
echo "Bosque Brewing Co. IPA";
var_dump($bosqueIPA->getBeerId()->toString());

// Create Bosque Lager
$bosqueLager = new Beer(
	generateUuidV4(),
	$bosque->getBreweryId(),
	4.8,
	"Inspired by German Pilsner.",
	"Bosque Lager",
	"German Pilsner");

//Insert Bosque Lager into database
$bosqueLager->insert($pdo);
echo "Bosque Brewing Co. IPA";
var_dump($bosqueLager->getBeerId()->toString());

// Create Bosque Lager
$bosqueLager = new Beer(
	generateUuidV4(),
	$bosque->getBreweryId(),
	4.8,
	"Inspired by German Pilsner.",
	"Bosque Lager",
	"German Pilsner");

//Insert Bosque IPA into database
$bosqueLager->insert($pdo);
echo "Bosque Brewing Co. IPA";
var_dump($bosqueLager->getBeerId()->toString());


























import React from "react";
import Card from "react-bootstrap/Card";
import Col from "react-bootstrap/Col";
import Row from "react-bootstrap/Row";

export function BeerCard (props) {
	console.log(props);
	//TODO replace beerBreweryId
	const {beerBreweryId, beerAbv, beerDescription, beerName, beerType} = props.beer;

	return (
		<Card className="beerCard">
		<Card.Img variant="top" src="https://www.placecage.com/1280/720" roundedCircle />
	<Card.Body className="cardTop">
		<Card.Title className="mb-2">{beerName}</Card.Title>
		<Card.Subtitle className="mb-2">{beerType}</Card.Subtitle>
		<Card.Subtitle className="mb-2">{beerBreweryId}</Card.Subtitle>
		<Card.Subtitle className="mb-2">{beerAbv}</Card.Subtitle>
	</Card.Body>
	<Card.Body className="cardBottom">
		<Card.Text className="beer-description\">{beerDescription}</Card.Text>
	</Card.Body>
	</Card>
	)
}
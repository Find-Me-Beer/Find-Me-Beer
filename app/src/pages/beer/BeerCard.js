import React from "react";
import Card from "react-bootstrap/Card";
import Col from "react-bootstrap/Col";
import Row from "react-bootstrap/Row";

export function BeerCard (props) {
	//need to be changed to beer stuff
	const {cardContent, postTitle, posDate} = props.beer;

	return (

	<Row>
	<Col md={3}>
		<Card className="beerCard">
		<Card.Img variant="top" src="https://www.placecage.com/1280/720" roundedCircle />
	<Card.Body className="cardTop">
		<Card.Title className="mb-2">Beer Name</Card.Title>
	<Card.Subtitle className="mb-2">Beer Type</Card.Subtitle>
	<Card.Subtitle className="mb-2">Brewery</Card.Subtitle>
	<Card.Subtitle className="mb-2">ABV</Card.Subtitle>
	</Card.Body>
	<Card.Body className="cardBottom">
		<Card.Text className="beer-description">
			Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
			labore et dolore magna aliqua.</Card.Text>
	</Card.Body>
	</Card>
	</Col>
	</Row>

	)


}
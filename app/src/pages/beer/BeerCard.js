import React from "react";
import Card from "react-bootstrap/Card";
import {BeerBreweryName} from "./BeerBreweryName";
import {Favorite} from "../Favorite"

export function BeerCard (props) {
	console.log(props);
	const {beerAbv, beerDescription, beerName, beerType} = props.beer;

	return (
		<Card className="beerCard">
			<Card.Body className="cardTop">
				<Card.Title className="mb-2">{beerName}</Card.Title>
				<Card.Subtitle className="mb-2">{beerType}</Card.Subtitle>
				<Card.Subtitle className="mb-2"><BeerBreweryName breweryId={beer.beerBreweryId} /></Card.Subtitle>
				<Card.Subtitle className="mb-2">{beerAbv}% ABV</Card.Subtitle>
			</Card.Body>
			<Card.Body className="cardBottom">
				<Card.Text className="beer-description\">{beerDescription}</Card.Text>
			</Card.Body>
		</Card>
	)
}





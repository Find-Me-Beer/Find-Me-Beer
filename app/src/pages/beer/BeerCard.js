
import React from 'react'
import { useSelector } from 'react-redux'
import Card from "react-bootstrap/Card";

export const BeerCard = ({ beer }) => {
console.log(beer);
	const breweries = useSelector((state) => state.breweries ? state.breweries : null);

	const FindBreweryName = () => {
		const brewery = breweries.find(brewery => beer.beerBreweryId === brewery.breweryId);
		console.log(brewery);
		return (
			<>
				{brewery &&<Card.Subtitle className="mb-2">{brewery.breweryName}</Card.Subtitle>}
			</>
		)
	};

	return (
		<Card className="beerCard">
			<Card.Body className="cardTop">
				<Card.Title className="mb-2">{beer.beerName}</Card.Title>
				<Card.Subtitle className="mb-2">{beer.beerType}</Card.Subtitle>
				<FindBreweryName/>
				<Card.Subtitle className="mb-2">{beer.beerAbv}% ABV</Card.Subtitle>
				<Favorite userId={userId} beerId={beer.beerId}/>
			</Card.Body>
			<Card.Body className="cardBottom">
				<Card.Text className="beer-description\">{beer.beerDescription}</Card.Text>
			</Card.Body>
		</Card>
	)
};


//<BeerBreweryName breweryId={beer.beerBreweryId} /></Card.Subtitle>





import React from 'react'
import { useSelector } from 'react-redux'
import Card from "react-bootstrap/Card";
import {Favorite} from "../Favorite";
import {UseJwt, UseJwtUserId} from "../../shared/misc/JwtHelpers";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Container from "react-bootstrap/Container";
import {BeerTagCard} from "./BeerTagCard";

export const BeerCard = ({ beer }) => {
	const breweries = useSelector((state) => state.breweries ? state.breweries : null);

	const beerTags = useSelector((state) => state.beerTags ? state.beerTags : null);
	const userId = UseJwtUserId();

	const FindBreweryName = () => {
		const brewery = breweries.find(brewery => beer.beerBreweryId === brewery.breweryId);
		return (
			<>
				{brewery &&<Card.Subtitle className="mb-2">{brewery.breweryName}</Card.Subtitle>}
			</>
		)
	};


	return (
		<Card className="beerCard">
			<Card.Body className="cardTop">
				<Container>
					<Row>
						<Col>
							<Card.Title className="mb-2">{beer.beerName}</Card.Title>
							<Card.Subtitle className="mb-2">{beer.beerType}</Card.Subtitle>
							<FindBreweryName/>
							<Card.Subtitle className="mb-2">{beer.beerAbv}% ABV</Card.Subtitle>
						</Col>
						<Favorite beerId={beer.beerId} userId={userId}/>
					</Row>
					{/*<Row>*/}
					{/*	<Col>*/}
					{/*		{beerTags.map(beerTag => <BeerTagCard beerTag={beerTag} key={beerTag.beerTagTagId}/>)}*/}
					{/*	</Col>*/}
					{/*</Row>*/}
				</Container>
			</Card.Body>
			<Card.Body className="cardBottom">
				<Card.Text className="beer-description\">{beer.beerDescription}</Card.Text>
			</Card.Body>
		</Card>
	)
};


//<BeerBreweryName breweryId={beer.beerBreweryId} /></Card.Subtitle>




import React, {useState, useEffect} from "react"
import {Link} from "react-router-dom";

import Button from "react-bootstrap/Button";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import FormControl from "react-bootstrap/FormControl";
import InputGroup from "react-bootstrap/InputGroup";
import CardColumns from "react-bootstrap/CardColumns";

import {getAllBeer, getBeerAndBreweries} from "../../shared/actions/get-beer";
import {BeerCard} from "./BeerCard";

import {useDispatch, useSelector} from "react-redux";

export const Beer = () => {
const dispatch = useDispatch();
const beer = useSelector(state => state.beer ? state.beer : []);

const sideEffects = () => {
	dispatch(getBeerAndBreweries());
	dispatch(getAllBeer());
};


const sideEffectInputs = [];

useEffect(sideEffects, sideEffectInputs);


return (
		<>
			<main>
				<Container className="search-container p-3" fluid={true}>
					<Row>
						<Col md={7} className>
						</Col>
						<Col md={4} className>
							<InputGroup className="mb-3">
								<FormControl
									placeholder="search for beer"
									aria-label="search for beer"
									aria-describedby="basic-addon2"
								/>
								<InputGroup.Append>
									<Button variant="outline-info" className="search-button">Find Me Beer!</Button>
								</InputGroup.Append>
							</InputGroup>
						</Col>
					</Row>
				</Container>
				<Container fluid={true} className="py-4 beer-container">
					<Row className="mb-4">
						<Col>
							<h1 className={"text-center found-beer-title"}>We Found You Beer!</h1>
						</Col>
					</Row>
						<CardColumns>
							{beer.map(beer => (<BeerCard beer={beer}/>))}
						</CardColumns>
				</Container>
			</main>
		</>
)
};





/* HORIZONTAL CARD DRAFT
<div style={{display: 'flex',  justifyContent:'center', alignItems:'center'}}>
	<Card style={{ width: '60%' }}>
		<Row className={"noGutters"}>
			<Col md={3}>
				<img src="https://www.placecage.com/200/200" roundedCircle alt="Beer"  />
			</Col>
			<Col md="auto">
				<Card.Body>
					<Card.Title>Beer Name</Card.Title>
					<Card.Subtitle>Beer Type</Card.Subtitle>
					<Card.Subtitle>Brewery Name</Card.Subtitle>
					<Card.Text>beerDescription</Card.Text>
					<Card.Text>beerAbv</Card.Text>
					<Col md={2}>
						<Button variant="warning">Favorite</Button>
					</Col>
				</Card.Body>
			</Col>
		</Row>
	</Card>
</div>
<Favorite beerId={beerId} userId={userId}/>
 */
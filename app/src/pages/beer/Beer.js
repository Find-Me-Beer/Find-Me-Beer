import React, {useState, useEffect} from "react"
import {Link} from "react-router-dom";

import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import FormControl from "react-bootstrap/FormControl";
import InputGroup from "react-bootstrap/InputGroup";

import {getAllBeer} from "../../shared/actions/get-beer";

import {Favorite} from "../Favorite";

import {getAllFavorites} from "../../shared/actions/get-favorite";
import {useDispatch, useSelector} from "react-redux";

export const Beer = () => {
const dispatch = useDispatch();
const beer = useSelector(state => state.beer ? state.beer : []);

const sideEffects = () => {
	dispatch(getAllBeer())
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
									<Button variant="outline-light" className="search-button">Find Me Beer!</Button>
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
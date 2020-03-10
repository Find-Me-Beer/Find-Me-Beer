import React, {useState, useEffect} from "react"
import {Link} from "react-router-dom";

import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";

export const Beer = () => {

return (
		<>
			<main>
				<Container fluid={true} className="py-4">
					<Row>
						<Col>
							<h1 className={"text-center"}>We Found You Beer!</h1>
						</Col>
					</Row>
					<Row>
						<Col md={3}>
							<Card>
								<Card.Img variant="top" src="https://www.placecage.com/1280/720" roundedCircle />
								<Card.Body>
									<Card.Title>Beer Name</Card.Title>
									<Card.Subtitle>Beer Type</Card.Subtitle>
									<Card.Subtitle>Brewery</Card.Subtitle>
									<Card.Text>
										Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
										labore et dolore magna aliqua.
									</Card.Text>
									<Button variant="warning">Favorite</Button>
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

 */
import React from "react";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Button from "react-bootstrap/Button";

import Image from "react-bootstrap/Image";
import Image1 from "../img/fmb-beer.jpg";
import Image2 from "../img/beer-mug.png";
import Image3 from "../img/location-tick.png";
import Image4 from "../img/favorite-star.png";



export const Home = () => {

	return (
		<>
			<main className="mh-100">
				<Container fluid="true">
					<Row>
						<Col className="col-12">
							<Image className="img-fluid" src={Image1} alt="beer foam in a glass" id="background-image" fluid/>
						</Col>
					</Row>
				</Container>
				<Container fluid="true">
					<Row>
						<Col className="col-6 offset-3 col-sm-4 offset-sm-0 mt-5 mb-3">
							<Image src={Image2} className="thumbs offset-2"/>
							<div className="ml-3 align-text-center">Discover New Beer Based On Preferences.</div>
						</Col>
						<Col className="col-6 offset-3 col-sm-4 offset-sm-0 mt-5 mb-3">
							<Image src={Image3} className="thumbs img-fluid offset-2"/>
							<div className="ml-1 align-text-center">Find Local Breweries Near Your Location.</div>
						</Col>
						<Col className="col-6 offset-3 col-sm-4 offset-sm-0 mt-5 mb-5 container">
							<Image src={Image4} className="thumbs img-fluid offset-2"/>
							<div className="ml-1 align-text-center">Keep a list of your favorite beer.</div>
						</Col>
					</Row>
				</Container>
				<Container fluid="true">
					<Row>
						<Col className="col-12 mt-5">
							<div className="mb-5">
								<Button variant="primary" size="lg" className="rounded">
									Find Me Beer!
								</Button>{' '}
							</div>
						</Col>
					</Row>
				</Container>
			</main>
		</>
	)
};

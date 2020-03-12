import React from "react";
import Card from "react-bootstrap/Card";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";

import Image from "react-bootstrap/Image";
import Image1 from "./shared/image/fmb-beer.jpg";
import Image2 from "./shared/image/beer-mug.png";
import Image3 from "./shared/image/location-tick.png";
import Image4 from "./shared/image/favorite-star.png";



export const Home = () => {

	return (
		<>
			<main className="mh-100">
				<Container fluid="true">
					<Row>
						<Col className="col-12">
							<Image className="img-fluid" src={Image1} alt="beer foam in a glass" id="background-image" fluid />
						</Col>
					</Row>
				</Container>
				<Container fluid="true">
					<Row>
						<Col className="col-12">
							<Col className="col-4">
								<Card.Img variant="top" src={Image2} className="img-position-center" />
								<Card.Subtitle className="mb-2 text-muted">Discover New Beer Based On Preferences.</Card.Subtitle>
							</Col>
							<Col className="col-4">
								<Card.Img variant="top" src={Image3} className="img-position-center" />
								<Card.Subtitle className="mb-2 text-muted">Card Subtitle</Card.Subtitle>
							</Col>
							<Col className="col-4">
								<Card.Img variant="top" src={Image4} className="img-position-center" />
								<Card.Subtitle className="mb-2 text-muted">Card Subtitle</Card.Subtitle>
							</Col>
						</Col>
					</Row>
				</Container>
			</main>

		</>
	)
};

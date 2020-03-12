import React from "react";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Image from "react-bootstrap/Image";
import Image1 from "./shared/image/fmb-beer.jpg";



export const Home = () => {

	return (
		<>
			<main className="d-flex align-items-center mh-100">
				<Container fluid="true">
					<Row>
						<Col>
							<br></br>
							<br></br>
							<br></br>
							<Image className="img-fluid" src={Image1} alt="beer foam in a glass" id="background-image" fluid />
						</Col>
					</Row>
				</Container>
				<Container fluid="true">
					<Row>
						<Col>
							<Card.Title>Card Title</Card.Title>
							<Card.Subtitle className="mb-2 text-muted">Card Subtitle</Card.Subtitle>
							<Card.Text>
								Some quick example text to build on the card title and make up the bulk of
								the card's content.
							</Card.Text>
							<Card.Title>Card Title</Card.Title>
							<Card.Subtitle className="mb-2 text-muted">Card Subtitle</Card.Subtitle>
							<Card.Text>
								Some quick example text to build on the card title and make up the bulk of
								the card's content.
							</Card.Text>
							<Card.Title>Card Title</Card.Title>
							<Card.Subtitle className="mb-2 text-muted">Card Subtitle</Card.Subtitle>
							<Card.Text>
								Some quick example text to build on the card title and make up the bulk of
								the card's content.
							</Card.Text>
						</Col>
					</Row>
				</Container>
			</main>

		</>
	)
};

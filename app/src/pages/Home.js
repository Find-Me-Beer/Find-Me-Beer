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
				<div className="home-background">
				<Container fluid="true">
					<Row>
						<Col className="col-12">
							<h1 className="home-page-text">Welcome To The Find Me Beer App</h1>
							{/*<Image className="img-fluid" src={Image1} alt="beer foam in a glass" id="background-image" fluid/>*/}
						</Col>
					</Row>
				</Container>
				</div>
				<Container>
					<Row>
						<Col>
							<h1 className="mt-5  col-9">FMB Features</h1>
						</Col>
					</Row>
				</Container>
				<Container fluid="true" className="py-5">
					<Row>
						<Col m={4} className="align-items-center justify-content-center">
							<Image src={Image2} className="thumbs mx-auto d-block"/>
							<h3 className="ml-3 align-text-center home-page-text">Discover New Beer Based On Preferences.</h3>
						</Col>
						<Col m={4}>
							<Image src={Image3} className="thumbs thumbs mx-auto d-block"/>
							<h3 className="ml-1 align-text-center home-page-text">Find Local Breweries Near Your Location.</h3>
						</Col>
						<Col m={4}>
							<Image src={Image4} className="thumbs thumbs mx-auto d-block"/>
							<h3 className="ml-1 align-text-center home-page-text">Keep a list of your favorite beer.</h3>
						</Col>
					</Row>
				</Container>
				<Container fluid="true" className="pb-5">
					<Row>
						<Col m={12}>
								<Button variant="primary" size="lg" className="rounded mx-auto d-block">
									Find Me Beer!
								</Button>{' '}
						</Col>
					</Row>
				</Container>
			</main>
		</>
	)
};

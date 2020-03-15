import React from "react";
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
						<Col className="col-6 offset-3 col-sm-4 offset-sm-0">
							<Image src={Image2} className="thumbs img-fluid"/>
							<div>Discover New Beer Based On Preferences.</div>
						</Col>
						<Col className="col-6 offset-3 col-sm-4 offset-sm-0">
							<Image src={Image3} className="thumbs img-fluid"/>
							<div>Find Local Breweries Near Your Location.</div>
						</Col>
						<Col className="col-6 offset-3 col-sm-4 offset-sm-0">
							<Image src={Image4} className="thumbs img-fluid" class="thumbs"/>
							<div>Discover New Beer Based On Preferences.</div>
						</Col>
					</Row>
				</Container>
			</main>
		</>
	)
};

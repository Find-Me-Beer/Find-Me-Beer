import React from "react";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Button from "react-bootstrap/Button";

import Image from "react-bootstrap/Image";
import Image2 from "../img/beer-mug.png";
import Image3 from "../img/location-tick.png";
import Image4 from "../img/favorite-star.png";
import Logo from '../img/fmb-navbar-logo.png';


export const Home = () => {

	return (
		<>
			<main className="mh-100">
				<div className="home-background mh-100">
					<Container fluid="true">
						<Row>
							<Col className="col-12">
								<h1 className="home-page-text-yellow mt-5 mb-5">Welcome!</h1>
									<Col className="col-12 offset-3 offset-xl-5">
										<Image className="logo-icon-large" src={Logo} />
									</Col>
								<Row className="offset-3 col-6">
									<p className="home-page-text">Find Me Beer has you covered when it comes to finding the perfect craft beer and then it
										will take you there! </p>
								</Row>
							</Col>
						</Row>
					</Container>
						</div>
						<Container>
							<Row>
								<Col>
									<h3 className="display-4 mt-5 d-bloc home-page-text-black">FMB! Features</h3>
								</Col>
							</Row>
						</Container>
						<Container fluid="true" className="py-5">
							<Row>
								<Col m={4}>
									<Image src={Image2} className="thumbs mx-auto d-block"/>
									<h3 className="ml-3 align-text-center home-page-text">Discover New Beer Based On
										Preferences.</h3>
								</Col>
								<Col m={4}>
									<Image src={Image3} className="thumbs mx-auto d-block"/>
									<h3 className="ml-1 align-text-center home-page-text">Find Local Breweries Near Your
										Location.</h3>
								</Col>
								<Col m={4}>
									<Image src={Image4} className="thumbs mx-auto d-block"/>
									<h3 className="align-text-center home-page-text">Keep a list of your favorite beer.</h3>
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

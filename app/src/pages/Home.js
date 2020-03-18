import React, {useEffect} from "react";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Button from "react-bootstrap/Button";

import Image from "react-bootstrap/Image";
import Image2 from "../img/fmb-navbar-logo-gray.png";
import Image3 from "../img/location-tick.png";
import Image4 from "../img/favorite-star.png";
import Logo from '../img/fmb-navbar-logo.png';
import {useDispatch} from "react-redux";
import {getEverythingButFavorites} from "../shared/actions/get-beer";


export const Home = () => {

	const dispatch = useDispatch();


	const effects = () => {
		dispatch(getEverythingButFavorites());
	};

	const inputs = [];

	useEffect(effects, inputs);

	return (
		<>
			<main className="mh-100 mw-100">
				<div className="home-background mh-100 mw-100 border border-warning border-top-0">
					<Container fluid="true py-3" xs={6} md={4}>
						<Row>
							<Col className="col-12">
								<h1 className="home-page-text-blue mt-5 mb-5">FIND ME BEER!</h1>
								<Col className="col-6 offset-3 offset-xl-5 rounded-bottom">
									<Image xs={12} md={3} className="logo-icon-large ml-3 offset-lg-4 offset-xl-4 container " src={Logo}/>
								</Col>
								<Row className="offset-3 col-6">
									<p className="home-p">Find Me Beer has you covered when it comes to helping you find your favorite craft beers
										and then FMB
										will take you to it! Sign up today and start finding beer!</p>
								</Row>
								<Container className="mt-5 d-block">
									<p className="col-6 offset-3 home-p">“Beer is proof that God loves us and wants us to be happy.”
										― Benjamin Franklin</p>
								</Container>
							</Col>
						</Row>
					</Container>
				</div>
				<Container>
					<Row>
						<Col>
							<h1 className="mt-5 home-page-text-black">FMB Features</h1>
						</Col>
					</Row>
				</Container>
				<Container lg={12} xs={12} md={6} sm={6} fluid="true" className="py-5">
					<Row>
						<Col xs={12} md={6} sm={6} className="container py-5">
							<Image src={Image2} className="thumbs mx-auto d-block"/>
							<p className="ml-3 align-text-center home-p">Discover New Beer Based On
								Preferences.</p>
						</Col>
						<Col xs={12} md={6} sm={6} className="container py-5">
							<Image src={Image3} className="thumbs mx-auto d-block"/>
							<p className="ml-1 align-text-center home-p col-xs-9">Find Local Breweries Near Your
								Location.</p>
						</Col>
						<Col lg={12} xs={12} md={12} sm={12} className="container py-5">
							<Image src={Image4} className="thumbs mx-auto d-block"/>
							<p className="align-text-center home-p">Keep a list of your favorite beer.</p>
						</Col>
					</Row>
				</Container>
				<Container fluid="true" className="pb-5">
					<Row lg={6} xs={6} md={6} sm={6} >
						<Col>
							<Button href="/beer" variant="primary" size="lg" className="col-6 home-page-text rounded mx-auto d-block">
								Find Me Beer
							</Button>{' '}
						</Col>
					</Row>
				</Container>
			</main>
		</>
	)
};

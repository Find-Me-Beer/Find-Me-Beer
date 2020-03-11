import React from "react"
import {Link} from "react-router-dom";

import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Image from 'image/fmb-beer.jpg';

export const Home = () => {
	return (
		<>
			<main>
				<Container>
					<Row>
						<Col xs={6} md={4}>
							<Image src="/image/fmb-beer.jpg" fluid />
						</Col>
					</Row>
				</Container>
			</main>
		</>
	);
}

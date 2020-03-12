import React from "react"
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Image from 'shared/image/fmb-beer.jpg';

export const Home = () => {
	return (
		<>
			<main>
				<Container>
					<Row>
						<Col xs={6} md={4}>
							<Image src="/image/fmb-beer.jpg" alt="beer" fluid />
						</Col>
					</Row>
				</Container>
			</main>
		</>
	);
};

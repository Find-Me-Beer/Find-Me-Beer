import React from 'react'
import { useSelector } from 'react-redux'
import Card from "react-bootstrap/Card";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Container from "react-bootstrap/Container";

export const TagCard = ({ tag }) => {
	const tags = useSelector((state) => state.tags ? state.tags : null);

	return (
			<Card className="beerCard">
				<Card.Body className="cardTop">
					<Container>
						<Row>
							<Col>
								<Card.Title>{tag.tagContent}</Card.Title>
							</Col>
						</Row>
					</Container>
				</Card.Body>
			</Card>
		)
};
import React from 'react'
import { useSelector } from 'react-redux'
import Card from "react-bootstrap/Card";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Container from "react-bootstrap/Container";
import {Favorite} from "../Favorite";

export const BeerTagCard = ({ beerTag }) => {
	const tags = useSelector((state) => state.tags ? state.tags : null);

	const FindTagContent = () => {
		const tag = tags.find(tag => beerTag.beerTagTagId === tag.tagId);
		return (
			<>
				<>
					<Card>
						<Card.Body>
							<Container>
								<Row>
									<Col>
										<Card.Title className="mb-2">{tag.tagContent}</Card.Title>
									</Col>
								</Row>
							</Container>
						</Card.Body>
					</Card>
				</>
			</>
		)
	};
		return (
			<>
				<FindTagContent/>
			</>
		)
	};

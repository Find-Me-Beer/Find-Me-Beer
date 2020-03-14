import React from "react"

import {SignUpForm} from "./SignUpForm";

import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Card from "react-bootstrap/Card";
import Badge from "react-bootstrap/Badge";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";

export const Signup = () => {
	return (
		<>
			<main className="d-flex align-items-center mh-100 my-5 my-md-0">
				<Container fluid="true" className="py-5">
					<Row>
						<Col md={6} lg={{span: 4, offset: 1}}>
							<Card bg="transparent" className="border-0 rounded-0">
								<Card.Header>
									<h3>Sign Up!</h3>
								</Card.Header>
								<Card.Body>
									<SignUpForm/>
								</Card.Body>
							</Card>
						</Col>
					</Row>
				</Container>
			</main>
		</>
	)
};
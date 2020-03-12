import React from "react";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import {Button} from "react-bootstrap";

/**
 * @return {undefined}
 */
function UseJwt() {

	return undefined;
}

export const Home = () => {

	// grab the jwt to check for logged in users. See JwtHelpers.js
	const jwt = UseJwt();

	return (
		<>
			<main className="d-flex align-items-center mh-100">
				<Container fluid="true">
					<Row>
						<Col sm={6} lg={{span: 4, offset: 1}}>

							{/* only render the signin form if user does not have a jwt, otherwise output a message */}
							{jwt === null ? (
								<SignInForm/>
							) : (
								<div>
									<span className="h2 mr-2">You're logged in!</span>
									&nbsp;
									<Link to="/posts">
										<Button className="btn-sm mb-2" variant="outline-dark">Head to Posts&nbsp;&nbsp;
										</Button>
									</Link>
								</div>
							)}

						</Col>
					</Row>
				</Container>
			</main>

		</>
	)
};

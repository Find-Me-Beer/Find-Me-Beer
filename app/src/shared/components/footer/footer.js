import React from "react";
import Col from "react-bootstrap/Col";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faEnvelope, faGithubAlt, } from "@fortawesome/free-brands-svg-icons";


export const Footer = () => (
	<>
		<footer className="page-footer footer-position">
			<Container className="container-fluid">
				<Row className="text-center text-white">
					<Col>
						<a href="https://github.com/Find-Me-Beer/Find-Me-Beer"  rel="noopener noreferrer" target="_blank">
							<i id="footerIcons">
								<FontAwesomeIcon icon={faGithubAlt} size="2x"/>
							</i>
						</a>
					</Col>

					<Col>
						<a href="mailto:FindMeBeer2020@gmail.com" rel="noopener noreferrer" target="_blank" >
							<i id="footerIcons">
								<FontAwesomeIcon icon="envelope" size="2x"/>
							</i>
						</a>
					</Col>
				</Row>
			</Container>
		</footer>
	</>
);
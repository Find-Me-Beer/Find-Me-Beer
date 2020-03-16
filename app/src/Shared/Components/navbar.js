import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import divWithClassName from "react-bootstrap/cjs/divWithClassName";
import {Link} from "react-router-dom";

import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import NavDropdown from "react-bootstrap/NavDropdown";
import Button from "react-bootstrap/Button";

import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Image from "react-bootstrap/Image";
import Col from "react-bootstrap/Col";


export const NavBar = () => {
	return (
		<>
			<header>
				<Navbar class="navbar" bg="primary" expand="md" variant="light">
					<Container>
						<Row>
							<Col xs={6} md={4}>
								<Image src="" rounded />
							</Col>
							<Col xs={6} md={4}>
								<img src="holder.js/171x180" roundedCirclee alt="logo" />
							</Col>
							<Col xs={6} md={4}>
								<img src="holder.js/171x180" thumbnail alt="logo" />
							</Col>
						</Row>
					</Container>
					<Link to="/">
						<Navbar.Brand>Find Me Beer!</Navbar.Brand>
					</Link>
					<Navbar.Toggle aria-controls="basic-navbar-nav">Find Me Beer</Navbar.Toggle>
					<Navbar.Collapse>
						<Nav className="ml-auto">
							<NavDropdown className="nav-link" title={"Profile"}>
								{/*<NavDropdown.Item href="/profile">*/}
								{/*	<FontAwesomeIcon icon="Favorites"/>&nbsp; Favorites*/}
								{/*</NavDropdown.Item>*/}
								<NavDropdown.Item>
									{/*<FontAwesomeIcon icon="Profile"/>&nbsp; Profile*/}
									<Nav.Link href="#link">Profile</Nav.Link>
									<div className="dropdown-divider"/>
								</NavDropdown.Item>
								<div className="dropdown-item log-out-dropdown">
									<button className="btn btn-outline-dark">
										Log Out&nbsp;<FontAwesomeIcon icon="log-out-alt"/>
									</button>
								</div>
							</NavDropdown>
						</Nav>
					</Navbar.Collapse>
				</Navbar>
			</header>
		</>
	)
};

